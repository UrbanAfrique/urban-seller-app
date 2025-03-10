<?php

namespace App\Http\Controllers;

use App\Enum\RouteTypeEnum;
use App\Enum\ShopifyEndPointEnum;
use App\Models\Order;
use App\Services\OrderService;
use App\Services\SellerService;
use App\Services\ShopifyService;
use App\Traits\General;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use General;

    public function index(Request $request)
    {
        $params = [
            'pageTitle' => trans('general.orders'),
            'routeType' => RouteTypeEnum::ORDER
        ];
        if ($this->isProxyRequest($request)) {
            $params = array_merge($params, $this->getProxyData());
            $vendorId = $params['vendor']->id;
            $params['orders'] = OrderService::getVendorOrderListing($vendorId);
            return response(view('proxy.orders.index', $params))->header('Content-Type', 'application/liquid');
        } else {
            $orders = Order::orderBy('id', 'DESC')->paginate(20);
            $params['orders'] = $orders;
            return view('app.orders.index', $params);
        }
    }

    public function show(Request $request, $orderId)
    {
        $params = [
            'pageTitle' => trans('general.detail_of') . " #",
            'routeType' => RouteTypeEnum::ORDER
        ];
        if ($this->isProxyRequest($request)) {
            $params = array_merge($params, $this->getProxyData());
            $vendorId = $params['vendor']->id;
            $order = Order::with(['order_items' => function ($q) use ($vendorId) {
                $q->join('products', 'products.product_id', 'order_items.product_id')
                    ->where('products.vendor_id', $vendorId);
            }, 'order_customer', 'order_billing_address', 'order_shipping_address'])
                ->orderBy('id', 'DESC')->find($orderId);
            $params['pageTitle'] = $params['pageTitle'] . $order->order_number;
            $params['order'] = $order;
            return response(view('proxy.orders.show', $params))->header('Content-Type', 'application/liquid');
        } else {
            $order = OrderService::findSingleOrder($orderId);
            $params['order'] = $order;
            $params['pageTitle'] = $params['pageTitle'] . $order->order_number;
            return view('app.orders.show', $params);
        }
    }

    public function applyFulfillmentWebhook(): JsonResponse
    {
        $fulfillment = json_decode(file_get_contents('php://input'), true);
        if ($fulfillment !== null) {
            $seller = SellerService::getSellerByDomain($_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN']);
            $request = ShopifyService::call($seller->token, $seller->domain, ShopifyEndPointEnum::ORDERS . "/" . $fulfillment['order_id']);
            $order = json_decode($request['response'], true)['order'];
            OrderService::manageOrder($seller, $order);
            OrderService::updateFulfill($fulfillment);
        }
        return response()->json(['status' => 200]);
    }

    public function createWebhook()
    {
        $order = json_decode(file_get_contents('php://input'), true);
        if ($order !== null) {
            // file_put_contents('order-create.txt', print_r($order, true));
            $seller = SellerService::getSellerByDomain($_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN']);
            if ($seller) {
                OrderService::manageOrder($seller, $order);
            }
            return response()->json(['status' => 200]);
        }
    }

    public function updateWebhook()
    {
        $order = json_decode(file_get_contents('php://input'), true);
        if ($order !== null) {
            // file_put_contents('order-update.txt', print_r($order, true));
            $seller = SellerService::getSellerByDomain($_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN']);
            if ($seller) {
                OrderService::manageOrder($seller, $order);
            }
            return response()->json(['status' => 200]);
        }
    }

    public function deleteWebhook()
    {
        return response()->json(['status' => 200]);
    }
}
