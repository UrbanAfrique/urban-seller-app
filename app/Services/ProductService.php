<?php

namespace App\Services;

use App\Enum\ApprovedStatusEnum;
use App\Enum\MethodEnum;
use App\Enum\ProductStatusEnum;
use App\Enum\ShopifyEndPointEnum;
use App\Enum\VendorTypeEnum;
use App\Models\Product;
use App\Models\Seller;
use App\Models\Variant;
use App\Traits\General;
use Illuminate\Http\JsonResponse;

class ProductService
{
    public static function getInventory($variants): string
    {
        if (count($variants) > 0) {
            return $variants[0]->inventory_quantity . " in stock";
        } else {
            $count = 0;
            foreach ($variants as $variant) {
                $count += $variant->inventory_quantity;
            }
            return $count . " in stock";
        }
    }


    public static function findById($id)
    {
        return Product::with('variants')->find($id);
    }

    public static function findProductByProductId($product_id)
    {
        return Product::where('product_id', $product_id)->first();
    }

    public static function getVariants($shopId, $productId)
    {
        return Variant::whereShopId($shopId)->whereProductId($productId)->get();
    }

    public static function manageProduct($seller, $product)
    {
        $productId = strval($product['id']);
        $sellerId = $seller->id;
        $dbProduct = Product::updateOrCreate(
            [
                'seller_id' => $sellerId,
                'product_id' => $productId
            ],
            [
                'title' => $product['title'] ?? null,
                'handle' => $product['handle'] ?? null,
                'product_type' => $product['product_type'] ?? null,
                'tags' => $product['tags'] ?? null,
                'body_html' => $product['body_html'] ?? null,
                'status' => $product['status'] ?? ProductStatusEnum::DRAFT,
                'template_suffix' => $product['template_suffix'] ?? null,
                'published_scope' => $product['published_scope'] ?? null,
                'created_at' => $product['created_at'] ?? null,
                'updated_at' => $product['updated_at'] ?? null,
                'published_at' => $product['published_at'] ?? null,
                'site_url' => null
            ]
        );
        if (isset($product['image']) && count($product['image'])) {
            $dbProduct->image = $product['image']['src'] ?? null;
        } else {
            $dbProduct->image = null;
        }
        if (isset($product['options']) && count($product['options']) > 0) {
            $dbProduct->option1 = $product['options'][0]['name'] ?? null;
            $dbProduct->option2 = $product['options'][1]['name'] ?? null;
            $dbProduct->option3 = $product['options'][2]['name'] ?? null;
            $dbProduct->options = json_encode($product['options']);
        }
        if ($dbProduct->save()) {
            if (isset($product['variants']) && count($product['variants'])) {
                self::manageVariants($dbProduct, $product['variants']);
            }
        }
        return $dbProduct;
    }

    public static function manageVariants($dbProduct, $variants)
    {

        foreach ($variants as $variant) {
            $variantId = trim($variant['id']);
            Variant::updateOrCreate([
                'variant_id' => $variantId,
                'product_id' => $dbProduct->id
            ], [
                'title' => $variant['title'] ?? null,
                'sku' => $variant['sku'] ?? null,
                'price' => $variant['price'] ?? null,
                'compare_at_price' => $variant['compare_at_price'] ?? null,
                'position' => $variant['position'] ?? null,
                'inventory_policy' => $variant['inventory_policy'] ?? null,
                'fulfillment_service' => $variant['fulfillment_service'] ?? null,
                'inventory_management' => $variant['inventory_management'] ?? null,
                'option1' => $variant['option1'] ?? null,
                'option2' => $variant['option2'] ?? null,
                'option3' => $variant['option3'] ?? null,
                'taxable' => $variant['taxable'] ?? null,
                'barcode' => $variant['barcode'] ?? null,
                'weight' => $variant['weight'] ?? null,
                'weight_unit' => $variant['weight_unit'] ?? null,
                'inventory_item_id' => isset($variant['inventory_item_id']) ? strval($variant['inventory_item_id']) : null,
                'inventory_quantity' => $variant['inventory_quantity'] ?? null,
                'old_inventory_quantity' => $variant['old_inventory_quantity'] ?? null,
                'requires_shipping' => $variant['requires_shipping'] ?? null,
                'created_at' => $variant['created_at'] ?? null,
                'updated_at' => $variant['updated_at'] ?? null
            ]);
        }
    }

    public static function deleteSellerProductByProductId($seller, $productId)
    {
        $products = Product::where('seller_id', $seller->id)
            ->where('product_id', strval($productId))
            ->get();
        if (count($products) > 0) {
            foreach ($products as $product) {
                $product->variants()->delete();
                $product->delete();
            }
        }
    }

    public static function generateProductParams($product): array
    {
        $params = [
            "product" => [
                "title" => $product->title ?? '',
                "vendor" => $product->product_vendor,
                "body_html" => $product->body_html ?? '',
                "product_type" => $product->product_type ?? '',
                'published_scope' => $product->published_scope ?? '',
                'tags' => $product->tags ?? ''
            ]
        ];
        if (empty($product->product_published_at)) {
            $params["product"]['published_at'] = date("Y-m-d") . "T00:00:00+03:00";
        }
        if ($product->product_id) {
            $params['product']['id'] = $product->product_id;
        }
        if ($product->status) {
            $params['product']['status'] = $product->status;
        }
        $options = [];
        foreach ([$product->option1, $product->option2, $product->option3] as $option) {
            if (!empty($option)) {
                $options[]['name'] = $option;
            }
        }
        if (!empty($options)) {
            $params['product']['options'] = $options;
        }
        if (is_array($product->shopify_images) && count($product->shopify_images) > 0) {
            $params['product']['images'] = $product->shopify_images;
        }
        $variants = [];
        foreach ($product->variants()->get() as $variant) {
            $vData = [
                'price' => $variant->price,
                'compare_at_price' => $variant->compare_at_price,
                'sku' => $variant->sku,
                'barcode' => $variant->barcode,
                'grams' => $variant->grams,
                'inventory_quantity' => $variant->inventory_quantity,
                'inventory_management' => 'shopify'
            ];

            if ($product->product_id && $variant->variant_id) {
                $vData['id'] = $variant->variant_id;
            }
            if ($variant->option1) {
                $vData['option1'] = $variant->option1;
            }
            if ($variant->option2) {
                $vData['option2'] = $variant->option2;
            }
            if ($variant->option3) {
                $vData['option3'] = $variant->option3;
            }
            $variants[] = $vData;
        }
        $params['product']['variants'] = array_values($variants);
        return $params;
    }

    public static function storeOrUpdate($mode = 'create', $product = null): Product
    {
        $data = request()->all();
        $vendor_id = $data['vendor_id'] ?? null;
        $seller_id = $data['seller_id'] ?? null;
        $product = ($mode == 'update') ? $product : new Product();

        $product->fill([
            'seller_id' => $seller_id,
            'vendor_id' => $vendor_id,
            'title' => $data['title'],
            'body_html' => $data['body_html'],
            'tags' => $data['tags'],
            'status' => $data['status'],
            'product_type' => $data['product_type'],
            'product_vendor' => $data['product_vendor'],
            'collections' => isset($data['collections']) ? json_encode($data['collections']) : null,

            'wholesale' => $data['wholesale'] ?? 0,
            'min_qty' => $data['min_qty'] ?? null,
            'discount_type' => $data['discount_type'] ?? null,
            'discount_value' => $data['discount_value'] ?? null,
        ]);
        $product->save();
        $options = $data['options'] ?? [];
        if (is_array($options) && count($options) > 0) {
            $product->option1 = $options[0] ?? null;
            $product->option2 = $options[1] ?? null;
            $product->option3 = $options[2] ?? null;
            $product->save();
        }
        self::manageProxyVariants($mode, $data, $product);
        return $product;
    }

    public static function manageProductImages($product, $mode): array
    {
        //Manage Product Images
        General::makeDirectory($product->id);
        $imageResponse = self::getProxyProductImages($product->id);
        if ($imageResponse['success'] === true) {
            $existingImages = ($mode == 'create') ? [] : $product->images;
            $newImages = $imageResponse['images'];
            if (count($newImages) > 0) {
                foreach ($newImages as $newImage) {
                    $existingImages[] = [
                        'id' => $newImage['id'],
                        'src' => $newImage['src']
                    ];
                }
            }
            $shopifyImages = [];
            foreach ($existingImages as $shopifyImage) {
                $shopifyImages[] = [
                    'alt' => $shopifyImage['id'],
                    'src' => $shopifyImage['src']
                ];
            }
            return [
                'existingImages' => $existingImages,
                'shopifyImages' => $shopifyImages
            ];
        } else {
            return [];
        }
    }

    private static function getProxyProductImages($pId): array
    {
        if (isset($_FILES['mFiles'])) {
            $images = [];
            $totalFiles = count($_FILES['mFiles']['name']);
            $uploadDir = "uploads/" . $pId . "/";
            for ($i = 0; $i < $totalFiles; $i++) {
                $tmpFilePath = $_FILES['mFiles']['tmp_name'][$i];
                $fileName = $_FILES['mFiles']['name'][$i];
                $finalImage = $uploadDir . uniqid() . '_' . $fileName;
                if (is_uploaded_file($tmpFilePath) && move_uploaded_file($tmpFilePath, public_path($finalImage))) {
                    $images[] = [
                        "id" => $finalImage,
                        "src" => asset($finalImage)
                    ];
                }
            }
            return [
                'success' => true,
                'images' => $images
            ];
        }
        return [
            'success' => false
        ];
    }

    public static function updateExistingProduct($product)
    {
        $params = ProductService::generateProductParams($product);
        // file_put_contents('update-products-params.txt', print_r($params, true));
        $seller = $product->seller;
        $request = ShopifyService::call(
            $seller->token,
            $seller->domain,
            ShopifyEndPointEnum::PRODUCTS . "/" . $product->product_id,
            $params,
            MethodEnum::PUT
        );
        $response = json_decode($request['response'], true);
        if (isset($response['product'])) {
            self::updateProductCollections($product);
            self::updateLocalVariantId($product, $response['product']);

            //metafield & discount handling
            if ($product->wholesale) {
                self::addUpdateMetefields($seller, $product);
                self::addUpdateAutomaticDiscount($seller, $product);
            } else {
                if (!empty($product->metafields)) {
                    self::deleteMetafield($seller, $product);
                    $product->metafields = null;
                }
                if (!empty($product->discount_id)) {
                    self::deleteDiscount($seller, $product);
                    $product->discount_id = null;
                }
                $product->save();
            }
        }
    }

    private static function updateProductCollections($product)
    {
        $collections = $product->collections;
        if (is_array($collections) && count($collections) > 0) {
            foreach ($collections as $collectionID) {
                ShopifyService::call(
                    $product->seller->token,
                    $product->seller->domain,
                    ShopifyEndPointEnum::COLLECTS,
                    [
                        'collect' => [
                            'product_id' => $product->product_id,
                            'collection_id' => $collectionID
                        ]
                    ],
                    MethodEnum::POST
                );
            }
        }
    }

    public static function manageApprovedProduct($seller, $product)
    {
        $params = ProductService::generateProductParams($product);
        $request = ShopifyService::call(
            $seller->token,
            $seller->domain,
            ShopifyEndPointEnum::PRODUCTS,
            $params,
            MethodEnum::POST
        );
        $response = json_decode($request['response'], true);
        if (isset($response['product'])) {
            $product->product_id = strval($response['product']['id']);
            $product->approved = ApprovedStatusEnum::APPROVED;
            $product->save();
            self::updateProductCollections($product);
            self::updateLocalVariantId($product, $response['product']);

            if ($product->wholesale) {
                self::addUpdateMetefields($seller, $product);
                self::addUpdateAutomaticDiscount($seller, $product);
            }
            return $response['product'];
        } else {
            return [];
        }
    }

    public static function addUpdateMetefields($seller, $product)
    {
        $query['query'] = 'mutation MetafieldsSet($metafields: [MetafieldsSetInput!]!) { metafieldsSet(metafields: $metafields) { metafields { id key namespace value createdAt updatedAt } userErrors { field message code } } }';
        $query['variables']['metafields'][] = [
            "key" => "discount",
            "namespace" => "wholesale",
            "ownerId" => "gid://shopify/Product/" . $product->product_id,
            "type" => "single_line_text_field",
            "value" => implode("|", [$product->min_qty, $product->discount_type, $product->discount_value])
        ];

        $request = ShopifyService::graphql($seller, $query);
        $response = json_decode($request['response'], true);

        $metafields = $response['data']['metafieldsSet']['metafields'] ?? [];
        if (!empty($metafields)) {
            $product->metafields = str_replace('gid://shopify/Metafield/', '', $metafields[0]['id']);
            $product->save();
        }
    }

    public static function deleteMetafield($shop, $product)
    {
        $endpoint = 'products/' . $product->product_id . '/metafields/' . $product->metafields;
        return ShopifyService::call($shop->token, $shop->domain, $endpoint, [], MethodEnum::DELETE);
    }

    public static function deleteDiscount($seller, $product)
    {
        $query['query'] = 'mutation discountAutomaticDelete($id: ID!) { discountAutomaticDelete(id: $id) { deletedAutomaticDiscountId userErrors { field code message } } }';
        $query['variables']['id'] = "gid://shopify/DiscountAutomaticNode/" . $product->discount_id;

        $request = ShopifyService::graphql($seller, $query);
        $response = json_decode($request['response'], true);

        return $response['data']['discountAutomaticDelete'] ?? [];
    }

    public static function addUpdateAutomaticDiscount($seller, $product)
    {
        $data = [
            "title" => "Wholesale discount " . $product->id,
            "startsAt" => date('Y-m-d') . "T00:00:00Z",
            "endsAt" => null,
            "minimumRequirement" => [
                "quantity" => ["greaterThanOrEqualToQuantity" => $product->min_qty],
            ],
            "customerGets" => [
                "appliesOnOneTimePurchase" => true,
                "value" => [],
                "items" => [
                    "products" => [
                        "productsToAdd" => ["gid://shopify/Product/" . $product->product_id]
                    ]
                ]
            ]
        ];
        if ($product->discount_type == 'percent') {
            $data['customerGets']['value'] = [
                'percentage' => round($product->discount_value / 100, 2)
            ];
        } else { // if discount_type == fix
            $data['customerGets']['value'] = [
                'discountAmount' => [
                    'amount' => $product->discount_value,
                    'appliesOnEachItem' => true
                ]
            ];
        }

        $queryType = 'Create($automaticBasicDiscount: DiscountAutomaticBasicInput!) { discountAutomaticBasicCreate(';
        if (!empty($product->discount_id)) {
            $query['variables']['id'] = "gid://shopify/DiscountAutomaticNode/" . $product->discount_id;
            $queryType = 'Update($id: ID!, $automaticBasicDiscount: DiscountAutomaticBasicInput!) { discountAutomaticBasicUpdate(id: $id, ';
        }

        $query['query'] = 'mutation discountAutomaticBasic' . $queryType . 'automaticBasicDiscount: $automaticBasicDiscount) { automaticDiscountNode { id automaticDiscount { ... on DiscountAutomaticBasic { startsAt endsAt minimumRequirement { ... on DiscountMinimumSubtotal { greaterThanOrEqualToSubtotal { amount currencyCode } } } customerGets { value { ... on DiscountAmount { amount { amount currencyCode } appliesOnEachItem } } items { ... on AllDiscountItems { allItems } } } } } } userErrors { field code message } } }';
        $query['variables']['automaticBasicDiscount'] = $data;
        // echo '<pre>' . json_encode($query);

        $request = ShopifyService::graphql($seller, $query);
        $response = json_decode($request['response'], true);

        // echo '<pre>'.json_encode($query);  print_r($response);

        $discount = $response['data']['discountAutomaticBasicCreate']['automaticDiscountNode'] ?? [];
        if (!empty($discount)) {
            $product->discount_id = str_replace('gid://shopify/DiscountAutomaticNode/', '', $discount['id']);
            $product->save();
        }
    }

    public static function removeUpdatedImages($product): array
    {
        //image management
        $productImages = $product->images;
        $shopifyImages = [];
        $deletedImages = [];
        if (is_array($productImages) && count($productImages) > 0) {
            $existingImages = array_column($productImages, 'id');
            $oldFiles = request()->input('oldFiles', []);
            if (is_array($oldFiles) && !empty($oldFiles)) {
                $deletedImages = array_diff($existingImages, $oldFiles);
                if (count($deletedImages) > 0) {
                    foreach ($deletedImages as $deletedImage) {
                        foreach ($productImages as $pKey => $pImage) {
                            if (trim(strval($pImage['id'])) === trim(strval($deletedImage))) {
                                $imagePath = public_path($deletedImage);
                                if (file_exists($imagePath)) {
                                    unlink($imagePath);
                                }
                                unset($productImages[$pKey]);
                            }
                        }
                    }
                }
            }
        }
        if (is_array($productImages) && count($productImages) > 0) {
            foreach ($productImages as $productImage) {
                $shopifyImages[] = [
                    'alt' => $productImage['id'],
                    'src' => $productImage['src'],
                ];
            }
        }
        $product->images = json_encode($productImages);
        $product->shopify_images = json_encode($shopifyImages);
        $product->save();

        return [
            "productImages" => $productImages,
            "deletedImages" => $deletedImages
        ];
    }

    public static function manageApproval($product): JsonResponse
    {
        $approved = request()->input('approved', ApprovedStatusEnum::PENDING);
        if ($approved == ApprovedStatusEnum::REJECTED) {
            $product->approved = $approved;
            $product->reject_reason = request()->input('reject_reason');
            $product->save();
            return response()->json([
                'success' => true,
                'approved' => self::getApprovedHtml($product, 'app'),
                'action' => view('components.products.action', [
                    'product' => $product,
                    'listType' => 'app'
                ])->render()
            ]);
        } else {
            $response = self::manageApprovedProduct(SellerService::getSeller(), $product);
            if (isset($response['id'])) {
                return response()->json([
                    'success' => true,
                    'approved' => ProductService::getApprovedHtml($product, 'app'),
                    'action' => view('components.products.action', [
                        'product' => $product,
                        'listType' => 'app'
                    ])->render()
                ]);
            } else {
                return response()->json([
                    'success' => false,
                ]);
            }
        }
    }

    public static function checkErrors(): array
    {
        $errors = [];
        $variants = request()->input('variants', array());
        if (count($variants) > 0) {
            $skus = $variants['sku'];
            $valueCounts = array_count_values($skus);
            $duplicates = array_filter($valueCounts, function ($count) {
                return $count > 1;
            });
            $duplicateValues = array_keys($duplicates);
            if (count($duplicateValues) > 0) {
                foreach ($duplicateValues as $duplicateValue) {
                    $errors[] = 'Sku ' . $duplicateValue . " is already exists";
                }
            }
        }
        return $errors;
    }

    private static function getProductInfo($d): string
    {
        $html = '';
        if (is_array($d->images) && count($d->images) > 0 && isset($d->images[0])) {
            $html .= '<img src="' . $d->images[0]['src'] . '" alt="' . $d->images[0]['id'] . '" class="avatar">';
        }
        $html .= $d->title;
        return $html;
    }

    public static function hasDefaultVariant($variants): bool
    {
        return isset($variants[0]) && $variants[0]->title === 'Default Title';
    }

    private static function manageProxyVariants($mode, $data, $product)
    {
        if ($mode == 'create') {
            self::createOrUpdateVariants($data['variants'] ?? [], $product, $data, $mode);
        } else {
            $isDefaultVariant = ProductService::hasDefaultVariant($product->variants);
            if ($isDefaultVariant && !empty($data['variants'])) {
                self::deleteExistingVariants($product);
                self::createOrUpdateVariants($data['variants'], $product, $data, $mode);
            } elseif ($isDefaultVariant && empty($data['variants'])) {
                self::deleteExistingVariants($product);
                self::createDefaultVariant($data, $product);
            } elseif (!$isDefaultVariant && empty($data['variants'])) {
                self::deleteExistingVariants($product);
                self::createDefaultVariant($data, $product);
            } else {
                if (isset($data['variants'])) {
                    // file_put_contents('manage-multi-variants.txt', print_r($data['variants'], true));
                    self::createOrUpdateVariants($data['variants'], $product, $data, $mode);
                }
            }
        }
    }

    private static function createOrUpdateVariants($variantsData, $product, $data, $mode)
    {
        if (!empty($variantsData['name'])) {
            foreach ($variantsData['name'] as $index => $variantName) {
                $variantNameArray = explode('/', $variantName);
                $condition = ['product_id' => $product->id];
                $sku = $variantsData['sku'][$index];
                if (isset($variantsData['id'][$index])) {
                    $condition['id'] = $variantsData['id'][$index];
                } else {
                    $condition['sku'] = $sku;
                }
                Variant::updateOrCreate($condition, [
                    'option1' => $variantNameArray[0] ?? null,
                    'option2' => $variantNameArray[1] ?? null,
                    'option3' => $variantNameArray[2] ?? null,
                    'title' => $variantName,
                    'sku' => $sku,
                    'price' => $variantsData['price'][$index],
                    'compare_at_price' => $variantsData['compare_at_price'][$index],
                    'inventory_quantity' => $variantsData['inventory_quantity'][$index],
                    'weight' => $variantsData['weight'][$index],
                    'barcode' => $variantsData['barcode'][$index],
                ]);
            }
        } else {
            self::createDefaultVariant($data, $product);
        }
    }

    private static function deleteExistingVariants($product)
    {
        Variant::where('product_id', $product->id)->delete();
    }

    private static function createDefaultVariant($data, $product)
    {
        Variant::updateOrCreate([
            'product_id' => $product->id,
            'sku' => $data['sku'],
        ], [
            'title' => "Default Title",
            'price' => $data['price'],
            'compare_at_price' => $data['compare_at_price'],
            'inventory_quantity' => $data['inventory_quantity'],
            'weight' => $data['weight'],
            'barcode' => $data['barcode'],
        ]);
    }

    public static function getApprovedHtml($product, $type = 'proxy'): string
    {
        $html = "";
        switch ($product->approved) {
            case ApprovedStatusEnum::APPROVED:
                $buttonClass = $type == 'proxy' ? 'w3-btn w3-tiny w3-green' : 'btn btn-sm btn-success';
                $status = ApprovedStatusEnum::getTranslationKeyBy(ApprovedStatusEnum::APPROVED);
                $html .= '<a class="' . $buttonClass . '">' . $status . '</a>';
                break;
            case ApprovedStatusEnum::PENDING:
                $buttonClass = $type == 'proxy' ? 'w3-btn w3-tiny w3-yellow' : 'btn btn-sm btn-warning';
                $status = ApprovedStatusEnum::getTranslationKeyBy(ApprovedStatusEnum::PENDING);
                $html .= '<a class="' . $buttonClass . '">' . $status . '</a>';
                break;
            case ApprovedStatusEnum::REJECTED:
                $buttonClass = $type == 'proxy' ? 'w3-btn w3-tiny w3-red' : 'btn btn-sm btn-danger';
                $status = ApprovedStatusEnum::getTranslationKeyBy(ApprovedStatusEnum::REJECTED);
                if ($type == 'app') {
                    $html .= '<div class="btn-group" role="group" aria-label="Basic example">';
                    $html .= '<a class="' . $buttonClass . '" style="border-top-right-radius: 3px;border-bottom-right-radius: 3px;">' . $status . '</a>';
                    $html .= '<a role="button" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="' . $product->reject_reason . '"><i class="fa fa-commenting-o px-2" aria-hidden="true" style="font-size: 18px;"></i></a>';
                    $html .= '</div>';
                } else {
                    $html .= '<div class="w3-tooltip">';
                    $html .= '<a class="' . $buttonClass . '">' . $status . '</a>';
                    $html .= '<a style="border-bottom: none !important;"><span style="position:absolute;left:0;bottom:18px" class="w3-text w3-tag">' . $product->reject_reason . '</span><i class="fa fa-commenting-o" aria-hidden="true" style="padding-left: 11px;font-size: 18px;"></i></a>';
                    $html .= '</div>';
                }
                break;
        }
        return $html;
    }


    public static function getStatusBtn($product, $type = 'proxy'): string
    {
        $status = $product->status;
        $btnClass = '';

        switch ($status) {
            case ProductStatusEnum::DRAFT:
                $btnClass = ($type == 'proxy') ? 'w3-button w3-red w3-tiny' : 'btn btn-sm btn-danger';
                break;

            case ProductStatusEnum::ACTIVE:
                $btnClass = ($type == 'proxy') ? 'w3-button w3-green w3-tiny' : 'btn btn-sm btn-success';
                break;

            case ProductStatusEnum::ARCHIVED:
                $btnClass = ($type == 'proxy') ? 'w3-button w3-yellow w3-tiny' : 'btn btn-sm btn-warning';
                break;
        }

        return '<a class="' . $btnClass . '">' . $status . '</a>';
    }


    public static function getStatusHtml($seller, $product, $type = 'proxy'): string
    {
        $selectClass = ($type == 'proxy') ? 'w3-border w3-medium w3-border-right-0 w3-input-sm-element w3-select' : 'form-control form-control-sm';
        $btnClass = ($type == 'proxy') ? 'w3-button w3-green w3-medium w3-border-left-0 w3-input-sm-btn' : 'btn btn-sm btn-success';
        $parentClass = $type == 'app' ? 'input-group' : 'w3-d-flex';
        $html = '<div class="' . $parentClass . '">';
        $html .= '<select class="' . $selectClass . '" name="">';
        foreach (ProductStatusEnum::getTranslationKeys() as $key => $value) {
            $selected = ($product->status == $key) ? 'selected' : '';
            $html .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
        }
        $html .= '</select>';
        $html .= '<button type="submit" class="' . $btnClass . '" onclick="productGenerator.updateProductStatus(this, \'' . route('app.product.status', [$product->id, 'shop' => optional($seller)->domain]).'\');">';
        $html .= '<i class="fa fa-plus-circle" aria-hidden="true"></i>';
        $html .= '</button>';
        $html .= '</div>';
        return $html;
    }

    private static function updateLocalVariantId($product, $apiProduct)
    {
        if (isset($product->variants) && count($product->variants)) {
            foreach ($product->variants as $vKey => $localVariant) {
                $apiVariant = $apiProduct['variants'][$vKey];
                if ($localVariant->sku == $apiVariant['sku']) {
                    $localVariant->variant_id = strval($apiVariant['id']);
                    $localVariant->save();
                }
            }
        }
    }

    public static function getImageByProductId($productId)
    {
        $product = self::findProductByProductId($productId);
        if (isset($product->shopify_images) and count($product->shopify_images)) {
            return $product->shopify_images[0]['src'] ?? asset('images/no_avatar.png');
        } else {
            return asset('images/no_avatar.png');
        }
    }
}
