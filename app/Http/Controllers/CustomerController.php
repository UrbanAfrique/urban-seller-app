<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Services\CustomerService;
use App\Services\SellerService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class CustomerController extends Controller
{
    public function createWebHook(): JsonResponse
    {
        $customer = json_decode(file_get_contents('php://input'), true);
        $seller = SellerService::getSellerByDomain($_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN']);
        if ($seller) {
            CustomerService::manage($seller,$customer);
        }
        return response()->json([
            'status' => 200
        ]);
    }

    /**
     * @throws Exception
     */
    public function updateWebHook(): JsonResponse
    {
        $customer = json_decode(file_get_contents('php://input'), true);
        // file_put_contents('customer.txt', print_r($customer,true));
        $seller = SellerService::getSellerByDomain($_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN']);
        if ($seller) {
            CustomerService::manage($seller,$customer);
        }
        return response()->json([
            'status' => 200
        ]);
    }

    public function deleteWebHook(): JsonResponse
    {
        $customer_id = json_decode(file_get_contents('php://input'), true)['id'];
        $shop = SellerService::getSellerByDomain($_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN']);
        if ($shop) {
            $customerId = trim($customer_id);
            $shopId = $shop->id;
            Customer::where('customer_id', $customerId)->where('seller_id', $shopId)->delete();
        }
        return response()->json([
            'status' => 200
        ]);
    }
}
