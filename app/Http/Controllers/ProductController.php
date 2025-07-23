<?php

namespace App\Http\Controllers;

use App\Enum\ApprovedStatusEnum;
use App\Enum\MethodEnum;
use App\Enum\ProductStatusEnum;
use App\Enum\RouteTypeEnum;
use App\Enum\ShopifyEndPointEnum;
use App\Enum\VendorTypeEnum;
use App\Models\Product;
use App\Models\Variant;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\SellerService;
use App\Services\SettingService;
use App\Services\ShopifyService;
use App\Traits\General;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class   ProductController extends Controller
{
    use General;

    public function createWebhook()
    {
        $product = json_decode(file_get_contents('php://input'), true);
        if ($product !== null) {
            return response()->json(['status' => 200]);
        }
    }

    public function updateWebhook()
    {
        $product = json_decode(file_get_contents('php://input'), true);
        if ($product !== null) {
            return response()->json(['status' => 200]);
        }
    }

    public function deleteWebhook()
    {
        $product = json_decode(file_get_contents('php://input'), true);
        if ($product !== null) {
            return response()->json(['status' => 200]);
        }
    }

    public function index(Request $request)
    {
        $keyword = request()->query('s');
        $products = Product::orderBy('id', 'DESC')
            ->with(['vendor' => function ($q) use ($keyword) {
                if ($keyword)
                    $q->orWhere('name', 'like', '%' . $keyword . '%');
            }, 'variants']);
        if ($keyword) {
            $products->orWhere('title', 'like', '%' . $keyword . '%');
        }
        $params = [
            'pageTitle' => trans('general.products'),
            'routeType' => RouteTypeEnum::PRODUCT
        ];
        
        if ($this->isProxyRequest($request)) {
            $params = array_merge($params, $this->getProxyData());
            $products = $products
                ->whereHas('vendor', function ($query) {
                    $query->where('vendor_type', VendorTypeEnum::VENDOR);
                })
                ->where('vendor_id', $params['vendor']->id)
                ->paginate(10)
                ->appends(request()->query());
            $params['products'] = $products;
            return response(view('proxy.products.index', $params))->header('Content-Type', 'application/liquid');
        } else {
            $params['products'] = $products->paginate(10)->appends(request()->query());
            return \view('app.products.index', $params);
        }
    }

    public function create(Request $request)
    {
        $params = [
            'pageTitle' => trans('general.create_product'),
            'routeType' => RouteTypeEnum::PRODUCT,
            // 'product' => new Product()
        ];
        if ($this->isProxyRequest($request)) {
            $params = array_merge($params, $this->getProxyData());
            return response(view('proxy.products.create', $params))
                ->header('Content-Type', 'application/liquid');
        } else {
            return \view('app.products.create', $params);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $errors = ProductService::checkErrors();
        if (count($errors) > 0) {
            return response()->json([
                'success' => false,
                'errors' => $errors
            ]);
        } else {
            $product = ProductService::storeOrUpdate();
            $finalImages = ProductService::manageProductImages($product, 'create');
            if (count($finalImages) > 0) {
                $product->images = json_encode($finalImages['existingImages']);
                $product->shopify_images = json_encode($finalImages['shopifyImages']);
                $product->save();
            }
            //Manage Auto Approval
            $seller = SellerService::findById($product->seller_id);
            $setting = SettingService::findBySellerId($seller->id);
            if ($setting->product_auto_approval) {
                ProductService::manageApprovedProduct($seller, $product);
            }
            return response()->json([
                'success' => true,
                'product' => $product,
                'finalImages' => $finalImages,
                'successMessage' => 'Product Create Successfully'
            ]);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $errors = ProductService::checkErrors();
        if (count($errors) > 0) {
            return response()->json([
                'success' => false,
                'errors' => $errors
            ]);
        } else {
            $product = ProductService::findById($id);
            ProductService::removeUpdatedImages($product);
            $product = ProductService::storeOrUpdate('update', $product);
            $finalImages = ProductService::manageProductImages($product, 'update');
            if (count($finalImages) > 0) {
                $product->images = json_encode($finalImages['existingImages']);
                $product->shopify_images = json_encode($finalImages['shopifyImages']);
                $product->save();
            }
            //Manage Auto Approval
            if ($product->approved == ApprovedStatusEnum::APPROVED) {
                ProductService::updateExistingProduct($product);
            }
            return response()->json([
                'success' => true,
                'finalImages' => $finalImages,
                'product' => $product,
                'successMessage' => 'Product Updated Successfully'
            ]);
        }
    }

    public function show(Request $request, $id)
    {
        $product = ProductService::findById($id);
        $isDefaultVariant = ProductService::hasDefaultVariant($product->variants);
        $params = [
            'pageTitle' => trans('general.detail_of') . " " . $product->title,
            'product' => $product,
            'isDefaultVariant' => $isDefaultVariant,
            'routeType' => RouteTypeEnum::PRODUCT
        ];
        if ($this->isProxyRequest($request)) {
            $params = array_merge($params, $this->getProxyData());
            return response(view('proxy.products.show', $params))->header('Content-Type', 'application/liquid');
        } else {
            return view('app.products.show', $params);
        }
    }

    public function edit(Request $request, $id)
    {
        $product = ProductService::findById($id);
        $isDefaultVariant = ProductService::hasDefaultVariant($product->variants);
        $params = [
            'pageTitle' => trans('general.edit') . " " . $product->title,
            'product' => $product,
            'isDefaultVariant' => $isDefaultVariant,
            'id' => $id,
            'routeType' => RouteTypeEnum::PRODUCT
        ];
        if ($this->isProxyRequest($request)) {
            $params = array_merge($params, $this->getProxyData());
            return response(view('proxy.products.edit', $params))
                ->header('Content-Type', 'application/liquid');
        } else {
            $params['seller'] = SellerService::getSeller();
            return view('app.products.edit', $params);
        }
    }

    public function changeStatus(Request $request, $id): JsonResponse
    {
        $product = ProductService::findById($id);
        $status = $request->input('status', ProductStatusEnum::DRAFT);
        if ($product) {
            $product->status = $status;
            $product->save();
            if ($product->approved) {
                $seller = SellerService::getSeller();
                ShopifyService::call(
                    $seller->token,
                    $seller->domain,
                    ShopifyEndPointEnum::PRODUCTS . "/" . $product->product_id,
                    [
                        'product' => [
                            'id' => $product->product_id,
                            'status' => $status
                        ]
                    ],
                    MethodEnum::PUT
                );
            }
            return response()->json([
                'success' => true,
                'message' => 'Successfully update the product status'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No Product found with this id'
            ]);
        }
    }

    public function delete(Request $request, $id): JsonResponse
    {
        $product = ProductService::findById($id);
        if ($product) {
            Variant::whereProductId($product->id)->delete();
            $product->delete();
            return response()->json([
                'success' => true,
                'message' => "Successfully Deleted the Product"
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => "No Product Found with Product id"
            ]);
        }
    }
}
