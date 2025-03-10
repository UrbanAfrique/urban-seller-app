<?php

namespace App\Services;

use App\Enum\MethodEnum;
use App\Enum\RoleEnum;
use App\Enum\ShopifyEndPointEnum;
use App\Enum\TableEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WebhookService
{
    public static function manage($token, $domain, $type, $id): void
    {
        self::deleteExistingWebhooks($token, $domain, $type, $id);
        self::createWebhooks($token, $domain, $type, $id, [
            'products/create',
            'products/update',
            'products/delete',
            'orders/create',
            'orders/updated',
            'collections/create',
            'collections/update',
            'collections/delete',
            'customers/create',
            'customers/update',
            'customers/delete',
            'fulfillments/create'
        ]);
    }
    public static function deleteExistingWebhooks($token, $domain, $type, $id)
    {
        $webhooks = self::getWebhooks($token, $domain);

        foreach ($webhooks as $webhook) {
            self::deleteWebhook($token, $domain, $webhook['id']);
        }

        $key = ($type == RoleEnum::SELLER) ? 'seller_id' : 'vendor_id';
        DB::table(TableEnum::WEBHOOKS)->where($key, $id)->delete();
    }

    public static function createWebhooks($token, $domain, $type, $id, $topics)
    {
        foreach ($topics as $topic) {
            $data = [
                'webhook' => [
                    'topic' => $topic,
                    'address' => env('SHOPIFY_ABSOLUTE_URL') . "/webhooks/$topic",
                    'format' => 'json'
                ]
            ];

            $response = self::callShopifyWebhook($token, $domain, $data);

            if (isset($response['webhook'])) {
                $key = ($type == RoleEnum::SELLER) ? 'seller_id' : 'vendor_id';
                DB::table(TableEnum::WEBHOOKS)->insert([
                    $key => $id,
                    'name' => $topic,
                    'web_hook_id' => strval($response['webhook']['id']),
                    'address' => $response['webhook']['address'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
        }
    }

    public static function getWebhooks($token, $domain)
    {
        $request = ShopifyService::call($token, $domain, ShopifyEndPointEnum::WEBHOOKS);
        $response = json_decode($request['response'], JSON_PRETTY_PRINT);
        return $response['webhooks'] ?? [];
    }

    public static function deleteWebhook($token, $domain, $webhookId)
    {
        $deleteUrl = ShopifyEndPointEnum::WEBHOOKS . "/$webhookId";
        ShopifyService::call($token, $domain, $deleteUrl, null, MethodEnum::DELETE);
    }

    public static function callShopifyWebhook($token, $domain, $data)
    {
        $request = ShopifyService::call($token, $domain, ShopifyEndPointEnum::WEBHOOKS, $data, MethodEnum::POST);
        return json_decode($request['response'], JSON_PRETTY_PRINT);
    }
}
