<?php

namespace App\Services;

use App\Enum\TransactionTypeEnum;
use App\Mail\VendorOrder;
use App\Mail\VendorRegister;
use App\Models\Order;
use App\Models\OrderBillingAddress;
use App\Models\OrderCustomer;
use App\Models\OrderItem;
use App\Models\OrderShippingAddress;
use App\Models\Transaction;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderService
{
    public static function manageOrder($seller, $order)
    {
        $order_id = strval($order['id']);
        $orderData = [
            'order_number' => $order['order_number'] ?? null,
            'subtotal_price' => $order['subtotal_price'] ?? null,
            'total_price' => $order['total_price'] ?? null,
            'total_price_usd' => $order['total_price_usd'] ?? null,
            'total_weight' => $order['total_weight'] ?? null,
            'total_tax' => $order['total_tax'] ?? null,
            'tax_lines' => isset($order['tax_lines']) ? json_encode($order['tax_lines']) : null,
            'currency' => $order['currency'] ?? null,
            'financial_status' => $order['financial_status'] ?? null,
            'fulfillment_status' => $order['fulfillment_status'] ?? null,
            'total_discounts' => $order['total_discounts'] ?? null,
            'discount_applications' => isset($order['discount_applications']) ? json_encode($order['discount_applications']) : null,
            'discount_codes' => isset($order['discount_codes']) ? json_encode($order['discount_codes']) : null,
            'total_line_items_price' => $order['total_line_items_price'] ?? null,
            'note' => $order['note'] ?? null,
            'note_attributes' => isset($order['note_attributes']) ? json_encode($order['note_attributes']) : null,
            'client_details' => isset($order['client_details']) ? json_encode($order['client_details']) : null,
            'payment_gateway_names' => isset($order['payment_gateway_names']) ? json_encode($order['payment_gateway_names'], JSON_FORCE_OBJECT) : null,
            'processing_method' => $order['processing_method'] ?? null,
            'checkout_id' => strval($order['checkout_id']) ?? null,
            'source_name' => $order['source_name'] ?? null,
            'contact_email' => $order['contact_email'] ?? null,
            'reference' => $order['reference'] ?? null,
            'confirmed' => $order['confirmed'] ?? null,
            'cancel_reason' => $order['cancel_reason'] ?? null,
        ];
        $dbOrder = Order::updateOrCreate([
            'seller_id' => $seller->id,
            'order_id' => $order_id
        ], $orderData);
        if (isset($order['line_items']) && count($order['line_items']) > 0) {
            foreach ($order['line_items'] as $line_item) {
                OrderItem::updateOrCreate([
                    'seller_id' => $seller->id,
                    'order_id' => $dbOrder->id,
                    'item_id' => strval($line_item['id']),
                ], [
                    'name' => $line_item['name'],
                    'quantity' => $line_item['quantity'],
                    'sku' => $line_item['sku'],
                    'vendor' => $line_item['vendor'],
                    'fulfillment_service' => $line_item['fulfillment_service'],
                    'requires_shipping' => $line_item['requires_shipping'],
                    'taxable' => $line_item['taxable'],
                    'grams' => $line_item['grams'],
                    'price' => $line_item['price'],
                    'total_discount' => $line_item['total_discount'],
                    'fulfillment_status' => $line_item['fulfillment_status'],
                    'product_id' => strval($line_item['product_id']),
                    'variant_id' => strval($line_item['variant_id'])
                ]);
            }
            self::vendorEmailnTransaction($dbOrder);
        }
        /*Manage Order Customer*/
        if (isset($order['customer']) && count($order['customer']) > 0) {
            $customer = $order['customer'];
            if (!empty($customer['id'])) {
                OrderCustomer::updateOrCreate([
                    'order_id' => $dbOrder->id,
                    'customer_id' => strval($customer['id'])
                ], [
                    'first_name' => $customer['first_name'] ?? null,
                    'last_name' => $customer['last_name'] ?? null,
                    'email' => $customer['email'] ?? null,
                    'phone' => $customer['phone'] ?? null,
                    'tags' => $customer['tags'] ?? null,
                    'orders_count' => $customer['orders_count'] ?? null,
                    'state' => $customer['state'] ?? null,
                    'total_spent' => $customer['total_spent'] ?? null,
                    'company' => $customer['default_address']['company'] ?? null,
                    'address1' => $customer['default_address']['address1'] ?? null,
                    'address2' => $customer['default_address']['address2'] ?? null,
                    'city' => $customer['default_address']['city'] ?? null,
                    'province' => $customer['default_address']['province'] ?? null,
                    'country' => $customer['default_address']['country'] ?? null,
                    'zip' => $customer['default_address']['zip'] ?? null,
                ]);
            }
        }
        /*Manage Order Billing Address*/
        if (isset($order['billing_address']) && count($order['billing_address']) > 0) {
            $billingAddress = $order['billing_address'];
            OrderBillingAddress::updateOrCreate([
                'order_id' => $dbOrder->id
            ], [
                'name' => $billingAddress['name'] ?? null,
                'phone' => $billingAddress['phone'] ?? null,
                'company' => $billingAddress['company'] ?? null,
                'address1' => $billingAddress['address1'] ?? null,
                'address2' => $billingAddress['address2'] ?? null,
                'city' => $billingAddress['city'] ?? null,
                'province' => $billingAddress['province'] ?? null,
                'province_code' => $billingAddress['province_code'] ?? null,
                'country' => $billingAddress['country'] ?? null,
                'country_code' => $billingAddress['country_code'] ?? null,
                'zip' => $billingAddress['zip'] ?? null,
                'latitude' => $billingAddress['latitude'] ?? null,
                'longitude' => $billingAddress['longitude'] ?? null,
            ]);
        }
        /*Manage Shipping Address*/
        if (isset($order['shipping_address']) && count($order['shipping_address']) > 0) {
            $shippingAddress = $order['shipping_address'];
            OrderShippingAddress::updateOrCreate([
                'order_id' => $dbOrder->id
            ], [
                'name' => $shippingAddress['name'] ?? null,
                'phone' => $shippingAddress['phone'] ?? null,
                'company' => $shippingAddress['company'] ?? null,
                'address1' => $shippingAddress['address1'] ?? null,
                'address2' => $shippingAddress['address2'] ?? null,
                'city' => $shippingAddress['city'] ?? null,
                'province' => $shippingAddress['province'] ?? null,
                'province_code' => $shippingAddress['province_code'] ?? null,
                'country' => $shippingAddress['country'] ?? null,
                'country_code' => $shippingAddress['country_code'] ?? null,
                'zip' => $shippingAddress['zip'] ?? null,
                'latitude' => $shippingAddress['latitude'] ?? null,
                'longitude' => $shippingAddress['longitude'] ?? null,
            ]);
        }
    }

    public static function findById($orderId)
    {
        return Order::with('order_items')->withCount('order_items')->find($orderId);
    }

    public static function updateFulfill($fulfillment)
    {
        $line_items = $fulfillment['line_items'];
        foreach ($line_items as $line_item) {
            $itemId = strval($line_item['item_id']);
            $dbItemQuery = OrderItem::where('item_id', $itemId)->where('order_id', strval($fulfillment['order_id']));
            if ($dbItemQuery->exists()) {
                $dbItem = $dbItemQuery->first();
                $dbItem->fulfillment_status = "fulfilled";
                $dbItem->save();
            }
        }
    }

    public static function getAjaxRecords()
    {
        $draw = request()->query('draw');
        $start = request()->query("start");
        $rowPerPage = request()->query("length");
        $columnIndex_arr = request()->query('order');
        $columnName_arr = request()->query('columns');
        $order_arr = request()->query('order');
        $search_arr = request()->query('search');
        $searchValue = $search_arr['value'];
        $columnSortOrder = $order_arr[0]['dir'];
        $columnIndex = $columnIndex_arr[0]['column'];
        $columnName = $columnName_arr[$columnIndex]['data'];
        if ($columnName != '0') {
            $columnName = "orders." . $columnName;
        } else {
            $columnName = "orders.created_at";
            $columnSortOrder = 'desc';
        }
        $records = Order::join('order_items', 'order_items.order_id', 'orders.id')
            ->join('order_customers', 'order_customers.order_id', 'orders.id')
            ->join('products', 'products.product_id', 'order_items.product_id')
            ->select(
                'orders.*',
                DB::raw("CONCAT(order_customers.first_name, ' ', order_customers.last_name) as customer_name"),
                DB::raw("(SELECT COUNT(*) FROM order_items
            JOIN products ON products.product_id = order_items.product_id
            WHERE order_items.order_id = orders.id) as order_items_count"),
                DB::raw("(SELECT SUM(order_items.price) FROM order_items
            JOIN products ON products.product_id = order_items.product_id
            WHERE order_items.order_id = orders.id) as total_order_items_price")
            );
        $records = $records->where('orders.order_id', 'like', '%' . $searchValue . '%');
        $totalRecords = $records->count();
        $totalRecordsWithFilter = $totalRecords;
        $records = $records->orderBy($columnName, $columnSortOrder);

        if ($start !== '0') {
            $records = $records->skip($start);
        }
        $records = $records->distinct()->take($rowPerPage)->get();
        $data_arr = array();
        foreach ($records as $d) {
            $data_arr[] = array(
                "DT_RowId" => "row_" . $d->id,
                'order' => ' <a href=' . route('order.show', [$d->id, 'shop' => SellerService::getSellerDomain()]) . '>#' . $d->order_number . '</a>',
                'date' => Carbon::parse($d->created_at)->format('d M Y \a\t h:i a'),
                'customer' => $d->customer_name,
                'total' => $d->total_order_items_price,
                'payment_status' => $d->financial_status,
                'fulfillment_status' => ($d->fulfillment_status) ?? trans('general.unfulfilled'),
                'items' => $d->order_items_count . " " . trans('general.items')
            );
        }
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordsWithFilter,
            "aaData" => $data_arr
        );
        echo json_encode($response);
        exit;
    }

    public static function getVendorOrderListing($vendorId): LengthAwarePaginator
    {
        return Order::with(['order_items', 'order_customer'])
            ->whereHas('order_items', function ($q) use ($vendorId) {
                $q->join('products', 'products.product_id', '=', 'order_items.product_id')
                    ->where('products.vendor_id', $vendorId);
            })
            ->orderBy('id', 'DESC')
            ->paginate(20);
    }

    public static function findSingleOrder($orderId)
    {
        return Order::with(['seller', 'order_items' => function ($query) {
            $query->join('products', 'products.product_id', 'order_items.product_id');
        }])->join('order_items', 'order_items.order_id', 'orders.id')
            ->join('order_customers', 'order_customers.order_id', 'orders.id')
            ->join('sellers', 'sellers.id', 'orders.seller_id')
            ->join('products', 'products.product_id', 'order_items.product_id')
            ->join('order_billing_addresses', 'order_billing_addresses.order_id', 'orders.id')
            ->join('order_shipping_addresses', 'order_shipping_addresses.order_id', 'orders.id')
            ->where('orders.id', $orderId)
            ->select(
                'orders.*',
                'orders.id as orderId',
                'order_customers.*',
                'sellers.domain as seller_domain',
                'sellers.id as seller_id',
                'order_billing_addresses.name as billing_name',
                'order_billing_addresses.phone as billing_phone',
                'order_billing_addresses.address1 as billing_address1',
                'order_billing_addresses.address2 as billing_address2',
                'order_billing_addresses.city as billing_city',
                'order_billing_addresses.country_code as billing_country_code',
                'order_shipping_addresses.name as shipping_name',
                'order_shipping_addresses.phone as shipping_phone',
                'order_shipping_addresses.address1 as shipping_address1',
                'order_shipping_addresses.address2 as shipping_address2',
                'order_shipping_addresses.city as shipping_city',
                'products.images as productImages',
                'order_shipping_addresses.country_code as shipping_country_code',
                DB::raw("CONCAT(order_customers.first_name, ' ', order_customers.last_name) as customer_name"),
                DB::raw("(SELECT COUNT(*) FROM order_items
            JOIN products ON products.product_id = order_items.product_id
            WHERE order_items.order_id = orders.id AND orders.id =$orderId) as order_items_count"),
                DB::raw("(SELECT SUM(order_items.price) FROM order_items
            JOIN products ON products.product_id = order_items.product_id
            WHERE order_items.order_id = orders.id AND orders.id =$orderId) as total_order_items_price")
            )->first();
    }

    public static function vendorEmailnTransaction($order)
    {
        $items = OrderItem::where('order_id', $order->id)->whereNotNull('p.vendor_id')
            ->leftJoin('products as p', 'order_items.product_id', '=', 'p.product_id')
            ->get();

        if (!empty($items)) {
            $orderItems = [];
            $balance = [];
            foreach ($items as $item) {
                $orderItems[$item->vendor_id][] = $item;
                if (!empty($balance[$item->vendor_id]))
                    $balance[$item->vendor_id] += ($item->price * $item->quantity) - $item->total_discount;
                else
                    $balance[$item->vendor_id] = ($item->price * $item->quantity) - $item->total_discount;
            }
            $seller = SellerService::findById($item->seller_id)->first();
            $detail_link = "https://" . $seller->domain . "/a/seller/orders/" . $order->id;

            foreach ($orderItems as $vendor_id => $items) {
                $vendor = Vendor::find($vendor_id);
                Mail::to($vendor->email)->send(new VendorOrder($vendor, $items, $detail_link));

                Transaction::updateOrCreate([
                    'order_id' => $order->id,
                    'vendor_id' => $vendor_id,
                    'type' => TransactionTypeEnum::SALE,
                ], [
                    'amount' => $balance[$vendor_id],
                    'detail' => 'order',
                    'seller_id' => $order->seller_id,
                    'status' => 1
                ]);
            }
        }
    }
}
