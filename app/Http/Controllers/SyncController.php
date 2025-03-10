<?php

namespace App\Http\Controllers;
use App\Enum\MethodEnum;
use App\Enum\ShopifyEndPointEnum;
use App\Models\Product;
use App\Services\ProductService;
use App\Services\ShopifyService;
use App\Services\SellerService;
use Illuminate\Http\Request;

class SyncController extends Controller
{
    public function vendorProducts(Request $request)
    {
        set_time_limit(0);
        $sellerShopId = $request->input('seller_shop_id');
        $vendorShopId = $request->input('vendor_shop_id');
        $sellerShop = SellerService::getSellerById($sellerShopId);
        $vendorShop = SellerService::getSellerById($vendorShopId);
        $vendorProductsQuery = Product::whereShopId($vendorShop->id)->where('is_synced', false);
        if ($vendorProductsQuery->exists()) {
            $vendorProducts = $vendorProductsQuery->get();
            foreach ($vendorProducts as $vendorProduct) {
                $vendorProductQuery = [
                    "title" => $vendorProduct->title,
                    "body_html" => $vendorProduct->body_html,
                    "vendor" => $vendorProduct->vendor,
                    "product_type" => $vendorProduct->product_type,
                    'tags' => explode(',', $vendorProduct->tags),
                    "published_scope" => "global",
                    'status' => 'draft',
                    "metafields" => [
                        [
                            'key' => 'vendor_shop_id',
                            'value' => $vendorProduct->shop_id,
                            "value_type" => "string",
                            "namespace" => "global"
                        ],
                        [
                            'key' => 'vendor_product_id',
                            'value' => $vendorProduct->id,
                            "value_type" => "string",
                            "namespace" => "global"
                        ]
                    ]
                ];

                $options = array();
                if ($vendorProduct->option1) {
                    $options[]['name'] = $vendorProduct->option1;
                }
                if ($vendorProduct->option2) {
                    $options[]['name'] = $vendorProduct->option2;
                }
                if ($vendorProduct->option3) {
                    $options[]['name'] = $vendorProduct->option3;
                }
                $vendorProductQuery['options'] = $options;
                /**
                 * Manage Variants
                 */
                $vendorProductVariants = ProductService::getVariants($vendorProduct->shop_id, $vendorProduct->id);
                $vParams = array();
                if (count($vendorProductVariants) > 0) {
                    foreach ($vendorProductVariants as $vendorProductVariant) {
                        $vParams[] = array(
                            'option1' => $vendorProductVariant->option1,
                            'option2' => $vendorProductVariant->option2,
                            'option3' => $vendorProductVariant->option3,
                            'price' => trim($vendorProductVariant->price),
                            'sku' => trim($vendorProductVariant->sku),
                            'barcode' => $vendorProductVariant->barcode,
                            'grams' => $vendorProductVariant->grams,
                            'inventory_quantity' => $vendorProductVariant->inventory_quantity,
                            'inventory_management' => $vendorProductVariant->inventory_management,
                            "metafields" => [
                                [
                                    'key' => 'vendor_shop_id',
                                    'value' => $vendorProduct->shop_id,
                                    "value_type" => "string",
                                    "namespace" => "global"
                                ],
                                [
                                    'key' => 'vendor_product_id',
                                    'value' => $vendorProduct->id,
                                    "value_type" => "string",
                                    "namespace" => "global"
                                ],
                                [
                                    'key' => 'vendor_variant_id',
                                    'value' => $vendorProductVariant->id,
                                    "value_type" => "string",
                                    "namespace" => "global"
                                ]
                            ]
                        );
                    }
                    $vendorProductQuery['variants'] = $vParams;
                }
                /**
                 * Manage Images
                 */
                if (!is_null($vendorProduct->images)) {
                    $images = json_decode($vendorProduct->images, TRUE);
                    $finalImagesArray = array();
                    if (count($images)) {
                        foreach ($images as $image) {
                            $finalImagesArray[] = [
                                'src' => $image['src'],
                                'alt' => implode(',', $image['variant_ids'])
                            ];
                            $vendorProductQuery['images'] = $finalImagesArray;
                        }
                    }
                }
                $request = ShopifyService::call($sellerShop->token, $sellerShop->domain,ShopifyEndPointEnum::PRODUCTS,[
                    'product' => $vendorProductQuery
                ], MethodEnum::POST);
                $response = json_decode($request['response'], JSON_PRETTY_PRINT);
                if (isset($response['product']) && count($response['product']) > 0) {
                    $vendorProduct->is_synced = true;
                    $vendorProduct->save();
                } else {
                    print_r($response);
                }
            }
        }
    }
}
