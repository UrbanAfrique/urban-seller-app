<?php

namespace App\Http\Controllers;

use App\Enum\ApprovedStatusEnum;
use App\Enum\FulfillmentStatusEnum;
use App\Enum\RouteTypeEnum;
use App\Mail\VendorApproval;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\SellerService;
use App\Services\ShopifyService;
use App\Services\VendorService;
use App\Traits\General;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class FulfillmentController extends Controller
{
    use General;

    public function create(Request $request, $orderId)
    {
        $order = OrderService::findSingleOrder($orderId);
        $pageTitle = trans('general.detail_of') . " #" . $order->order_number;
        $params = [
            'routeType' => RouteTypeEnum::ORDER_FULFILL,
            'pageTitle' => $pageTitle,
            'order' => $order
        ];
        if ($this->isProxyRequest($request)) {
            $params = array_merge($params, $this->getProxyData());
            return response(view('proxy.fulfillments.create',$params))->header('Content-Type', 'application/liquid');
        }else{
            return view('app.fulfillments.create',$params);
        }
    }

    public function store(Request $request, $order_id)
    {
        $seller_id = $request->input('seller_id');
        $seller = SellerService::findById($seller_id);
        $order = OrderService::findById($order_id);

        $order_items_count = $order->order_items_count;
        $items = $request->input('items', []);
        $quantities = $request->input('quantities', []);
        $tracking_number = $request->input('tracking_number');
        $shipping_career = $request->input('shipping_career');
        $firstRequest = ShopifyService::call($seller->token, $seller->domain, 'orders/' . $order->order_id . '/fulfillment_orders');
        $firstResponse = json_decode($firstRequest['response'], true);
        $fulfilled_ids = [];
        $finalParams = [
            "fulfillment" => [
                'notify_customer' => true,
                'tracking_info' => [
                    'number' => $tracking_number,
                    'company' => $shipping_career
                ]
            ]
        ];
        if (isset($firstResponse['fulfillment_orders'])) {
            foreach ($firstResponse['fulfillment_orders'] as $fulfillment_order) {
                $innerLineItem = [
                    'fulfillment_order_id' => $fulfillment_order['id']
                ];
                foreach ($fulfillment_order['line_items'] as $orderLineItem) {
                    $orderItemId = $orderLineItem['line_item_id'];
                    if (isset($items[$orderItemId])) {
                        $innerLineItem['fulfillment_order_line_items'][] = [
                            'id' => $orderLineItem['id'],
                            'quantity' => $quantities[$orderItemId]
                        ];
                    }
                }
                $fulfilled_ids[] = $innerLineItem;
            }
            $finalParams['fulfillment']['line_items_by_fulfillment_order'] = $fulfilled_ids;
            $secondRequest = ShopifyService::call($seller->token, $seller->domain, 'fulfillments', $finalParams, 'POST');
            $secondResponse = json_decode($secondRequest['response'], true);
            //update order item fulfilment status
            $fulfilledCount = 0;
            if (isset($secondResponse['fulfillment'])) {
                if (isset($secondResponse['fulfillment']['line_items']) && count($secondResponse['fulfillment']['line_items']) > 0) {
                    foreach ($secondResponse['fulfillment']['line_items'] as $lineItem) {
                        $orderItemId = strval($lineItem['id']);
                        $orderItemQuery = OrderItem::where('item_id', $orderItemId);
                        if ($orderItemQuery->exists()) {
                            $orderItem = $orderItemQuery->first();
                            $orderItem->fulfillment_status = FulfillmentStatusEnum::FUlFILLED;
                            $orderItem->save();
                            $fulfilledCount++;
                        }
                    }
                }
            }

            if ($fulfilledCount === $order_items_count) {
                $order->financial_status = FulfillmentStatusEnum::FUlFILLED;
            } else {
                $order->financial_status = FulfillmentStatusEnum::PARTIAL;
            }
            $order->save();
            return response()->json([
                'params' => $finalParams,
                'firstRequest' => $firstRequest,
                'secondResponse' => $secondResponse,
                'success' => true
            ]);
        }
    }
}
