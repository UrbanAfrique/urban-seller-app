<?php

namespace App\Http\Controllers;

use App\Enum\RouteTypeEnum;
use App\Enum\ShopifyEndPointEnum;
use App\Enum\VendorTypeEnum;
use App\Models\Vendor;
use App\Services\SellerService;
use App\Services\ShopifyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function index(Request $request)
    {

    }

    public function create(Request $request)
    {
        $seller = SellerService::getSeller();
        $pageTitle = "Manage Settings";
        $routeType = RouteTypeEnum::SELLER;
        return view('sellers.create', compact(
            'routeType',
            'pageTitle',
            'seller'
        ));
    }

    public function update(Request $request, $id)
    {
        $seller = SellerService::findById($id);
        if ($request->has('email')) {
            $term_of_use = $request->input('term_of_use', false);
            $privacy_policy = $request->input('privacy_policy', false);
            $seller->term_of_use = $term_of_use == 'on';
            $seller->privacy_policy = $privacy_policy == 'on';
            $seller->save();
            return redirect()->route('app.settings.index', [
                'shop' => $seller->domain,
                'timestamp' => time(),
                'success' => true,
                'successMessage' => 'Configuration updated Successfully'
            ]);
        }
    }

    public function getSeller(Request $request, $domain, $customerId): JsonResponse
    {
        $customer = SellerService::findByDomain($domain);
        $request = ShopifyService::call($customer->token, $customer->domain, ShopifyEndPointEnum::CUSTOMERS . "/" . $customerId);
        $customer = json_decode($request['response'], true);
        return response()->json([
            'customer' => $customer,
            'vendor' => Vendor::where('domain', $domain)->whereType(VendorTypeEnum::VENDOR)->first()
        ]);
    }
}
