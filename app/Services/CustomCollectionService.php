<?php

namespace App\Services;

use App\Enum\ShopifyEndPointEnum;
use App\Models\CustomCollection;

class CustomCollectionService
{
    public static function getDropdownBySellerId($sellerId)
    {
        return CustomCollection::whereSellerId($sellerId)->pluck('title','collection_id');
    }

    public static function findById($id)
    {
        return CustomCollection::find($id);
    }

    public static function findByCustomCollectionId($collection_id)
    {
        return CustomCollection::where('collection_id', $collection_id)->first();
    }

    public static function manage($seller, $collection)
    {
        $collectionId = strval($collection['id']);
        $data = [
            'handle' => $collection['handle'] ?? '',
            'title' => $collection['title'] ?? '',
            'body_html' => $collection['body_html'] ?? '',
            'sort_order' => $collection['sort_order'] ?? '',
            'template_suffix' => $collection['template_suffix'] ?? '',
            'published_scope' => $collection['published_scope'] ?? '',
            'admin_graphql_api_id' => $collection['admin_graphql_api_id'] ?? '',
            'src' => $collection['image']['src'] ?? ''
        ];
        return CustomCollection::updateOrCreate([
            'seller_id' => $seller->id,
            'collection_id' => $collectionId,
        ], $data);
    }

    public static function syncAll($seller)
    {
        $request = ShopifyService::call($seller->token, $seller->domain, ShopifyEndPointEnum::CUSTOM_COLLECTIONS);
        $collections = json_decode($request['response'], true)['custom_collections'];
        foreach ($collections as $collection) {
            self::manage($seller, $collection);
        }
    }

}
