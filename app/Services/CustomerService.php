<?php

namespace App\Services;

use App\Enum\ShopifyEndPointEnum;
use App\Models\Customer;

class CustomerService
{
    public static function findById($id)
    {
        return Customer::find($id);
    }

    public static function findByCustomerId($customerId)
    {
        return Customer::where('customer_id', $customerId)->first();
    }

    public static function getLoggedInCustomer($customerId, $sellerId)
    {
        return Customer::whereHas('vendor')->whereCustomerId($customerId)->whereSellerId($sellerId)->first();
    }

    public static function manage($seller, $customer)
    {
        $customerId = strval($customer['id']);
        $email = $customer['email'] ?? null;
        $data = [
            'email' => $email,
            'accepts_marketing' => $customer['accepts_marketing'] ?? null,
            'first_name' => $customer['first_name'] ?? null,
            'last_name' => $customer['last_name'] ?? null,
            'orders_count' => $customer['orders_count'] ?? null,
            'state' => $customer['state'] ?? null,
            'total_spent' => $customer['total_spent'] ?? null,
            'last_order_id' => $customer['last_order_id'] ?? null,
            'last_order_name' => $customer['last_order_name'] ?? null,
            'verified_email' => $customer['verified_email'] ?? null,
            'multipass_identifier' => $customer['multipass_identifier'] ?? null,
            'tags' => $customer['tags'] ?? null,
            'currency' => $customer['currency'] ?? null,
            'phone' => $customer['phone'] ?? null,
            'accepts_marketing_updated_at' => $customer['accepts_marketing_updated_at'] ?? null,
            'marketing_opt_in_level' => $customer['marketing_opt_in_level'] ?? null,
            'admin_graphql_api_id' => $customer['admin_graphql_api_id'] ?? null,
            // 'default_address' => json_encode($customer['default_address']) ?? null,
            'addresses' => json_encode($customer['addresses']) ?? null,
            'note' => $customer['note'] ?? null,
            'tax_exemptions' => json_encode($customer['tax_exemptions']) ?? null,
            'email_marketing_consent' => json_encode($customer['email_marketing_consent']) ?? null,
            'sms_marketing_consent' => json_encode($customer['sms_marketing_consent']) ?? null,
            'created_at' => $customer['created_at'],
            'updated_at' => $customer['updated_at']
        ];
        return Customer::updateOrCreate([
            'seller_id' => $seller->id,
            'customer_id' => $customerId,
            'email' => $email
        ], $data);
    }

    public static function getCustomerQuery($vendor = null): array
    {
        $name = request()->input('name');
        $nameArray = explode(' ', $name);
        $phone = request()->input('phone');
        $data = [
            "customer" => [
                "first_name" => $nameArray[0],
                "last_name" => $nameArray[1],
                "email" => $vendor ? $vendor->email : request()->input('email'),
                // "phone" => $phone,
                "tags" => request()->input('tags')
            ]
        ];
        if (!$vendor) {
            $data['customer']['addresses'] = [
                [
                    "first_name" => $nameArray[0],
                    "last_name" => $nameArray[1],
                    "name" => $name,
                    "phone" => $phone,
                    "company" => request()->input('company', null),
                    "address1" => request()->input('address1', null),
                    "address2" => request()->input('address2', null),
                    "city" => request()->input('city', null),
                    "province" => request()->input('province', null),
                    "zip" => request()->input('zip', null),
                    "country" => request()->input('country', null)
                ]
            ];
        }
        if (request()->has('password')) {
            $data['customer']['password'] = request()->input('password');
        }
        if (request()->has('password_confirmation')) {
            $data['customer']['password_confirmation'] = request()->input('password_confirmation');
        }

        return $data;
    }

    public static function syncAll($seller)
    {
        $request = ShopifyService::call($seller->token, $seller->domain, ShopifyEndPointEnum::CUSTOMERS);
        $customers = json_decode($request['response'], true)['customers'];
        foreach ($customers as $customer) {
            self::manage($seller, $customer);
        }
    }

    public static function deleteCustomer($seller, $customerId)
    {
        return Customer::where('seller_id', $seller->id)
            ->where('customer_id', strval($customerId))
            ->delete();
    }
}
