<?php

namespace App\Services;

use App\Enum\ShopifyEndPointEnum;
use App\Models\Error;
use App\Models\Product;
use App\Models\Seller;
use App\Models\Vendor;

class SellerService
{
    public static function getSellerId()
    {
        return self::getSeller()->id;
    }

    public static function getSeller()
    {
        return Seller::with('setting')->where('domain', self::getSellerDomain())->first();
    }

    public static function getSellerDomain()
    {
        return request()->get('shop', null);
    }

    public static function getSellerById($id)
    {
        return Seller::find($id);
    }

    public static function getErrors($sellerId)
    {
        return Error::whereSellerId($sellerId)->get();
    }

    public static function getSellerByDomain($domain)
    {
        return Seller::where('domain', $domain)->first();
    }

    public static function alreadyHasVendorProduct($vProductId, $sellerId)
    {
        return Product::whereSellerId($sellerId)
            ->whereNotNull('vendor_id')
            ->whereVendorProductId(strval($vProductId))
            ->exists();
    }

    public static function getVendorProducts($sellerId)
    {
        return Product::whereSellerId($sellerId)
            ->whereNotNull('vendor_id')
            ->get();
    }

    public static function sync($seller)
    {
        $response = ShopifyService::call(
            $seller->token,
            $seller->domain,
            ShopifyEndPointEnum::SHOP,
            null);
        $response = json_decode($response['response'], JSON_PRETTY_PRINT);
        if (isset($response['shop']) && count($response['shop']) > 0) {
            $shop = $response['shop'];
            return Seller::updateOrCreate([
                'domain' => $shop['myshopify_domain']
            ], [
                'email' => $shop['email'] ?? null,
                'store_id' => strval($shop['id']) ?? null,
                'primary_location_id' => strval($shop['primary_location_id']) ?? null,
                'primary_locale' => $shop['primary_locale'] ?? null,
                'country' => $shop['country'] ?? null,
                'province' => $shop['province'] ?? null,
                'city' => $shop['city'] ?? null,
                'address1' => $shop['address1'] ?? null,
                'address2' => $shop['address2'] ?? null,
                'zip' => $shop['zip'] ?? null,
                'latitude' => $shop['latitude'] ?? null,
                'longitude' => $shop['longitude'] ?? null,
                'currency' => $shop['currency'] ?? null,
                'money_format' => $shop['money_format'] ?? null,
                'name' => $shop['name'] ?? null,
                'owner' => $shop['shop_owner'] ?? null,
                'created_at' => $shop['created_at'] ?? null,
                'updated_at' => $shop['updated_at'] ?? null
            ]);
        }
    }

    public static function findByDomain($domain)
    {
        return Seller::with('setting')
            ->where('domain', $domain)
            ->first();
    }

    public static function findBySellerId($sellerId)
    {
        return Seller::with('setting')
            ->where('seller_id', $sellerId)
            ->first();
    }

    public static function findById($sellerId)
    {
        return Seller::with('setting')
            ->where('id', $sellerId)
            ->first();
    }

}
