<?php

namespace App\Http\Controllers;

use App\Models\CustomCollection;
use App\Services\CustomCollectionService;
use App\Services\SellerService;
use Illuminate\Http\JsonResponse;

class CollectionController extends Controller
{
    public function createWebhook(): JsonResponse
    {
        $collection = json_decode(file_get_contents('php://input'), true);
        // file_put_contents("create-collection.txt",print_r($collection,true));
        $seller = SellerService::findByDomain($_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN']);
        if ($seller && !isset($collection['rules'])) {
            CustomCollectionService::manage($seller, $collection);
        }
        return response()->json(['status' => 200]);
    }

    public function updateWebhook(): JsonResponse
    {
        $collection = json_decode(file_get_contents('php://input'), true);
        // file_put_contents("update-collection.txt",print_r($collection,true));
        $seller = SellerService::findByDomain($_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN']);
        if ($seller && !isset($collection['rules'])) {
            CustomCollectionService::manage($seller, $collection);
        }
        return response()->json(['status' => 200]);
    }

    public function deleteWebhook(): JsonResponse
    {
        $collectionId = json_decode(file_get_contents('php://input'), true)['id'];
        // file_put_contents("delete-collection.txt",$collectionId);
        $seller = SellerService::findByDomain($_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN']);
        if ($seller) {
            CustomCollection::whereCollectionId(strval($collectionId))->whereSellerId($seller->id)->delete();
        }
        return response()->json(['status' => 200]);
    }

}
