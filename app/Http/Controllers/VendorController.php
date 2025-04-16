<?php

namespace App\Http\Controllers;

use App\Enum\ApprovedStatusEnum;
use App\Enum\MethodEnum;
use App\Enum\RouteTypeEnum;
use App\Enum\ShopifyEndPointEnum;
use App\Enum\TableEnum;
use App\Enum\VendorStatusEnum;
use App\Mail\VendorApproval;
use App\Mail\VendorRegister;
use App\Mail\AdminNotification;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Vendor;
use App\Services\CustomerService;
use App\Services\SellerService;
use App\Services\ShopifyService;
use App\Services\VendorService;
use App\Traits\General;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class VendorController extends Controller
{
    use General;

    public function proxyDashboard()
    {
        $data = $this->getProxyData();
        $vendor = $data['vendor'];
        $customer = $data['vendor']->customer;
        $seller = $data['seller'];
        if ($vendor->approved == ApprovedStatusEnum::PENDING) {
            $data['pageTitle'] = trans('general.pending_approval');
            return response(view('proxy.vendors.pending', $data))->header('Content-Type', 'application/liquid');
        } else if ($vendor->approved == ApprovedStatusEnum::REJECTED) {
            $data['pageTitle'] = trans('general.rejected');
            return response(view('proxy.vendors.rejected', $data))->header('Content-Type', 'application/liquid');
        } else if (!$customer->subscribed('default')) {
            return redirect()->to('https://' . $seller->shop_domain . '/a/seller/plan/payout-create?customerId=' . $customer->id);
        }
        $data['pageTitle'] = __('general.dashboard');
        $data['total_products'] = Product::whereVendorId($vendor->id)->count();
        $data['approved_products'] = Product::whereVendorId($vendor->id)->whereApproved(ApprovedStatusEnum::APPROVED)->count();
        $data['unapproved_products'] = Product::whereVendorId($vendor->id)->whereApproved(ApprovedStatusEnum::PENDING)->count();
        $data['total_orders'] = Order::whereHas('order_items', function ($q) use ($vendor) {
            $q->join('products', 'products.product_id', '=', 'order_items.product_id')
                ->where('products.vendor_id', $vendor->id);
        })->count();
        $data['balance'] = Transaction::where('vendor_id', $vendor->id)->sum('amount');
        $data['balance_sum'] = Transaction::where('amount', '>', 0)->where('vendor_id', $vendor->id)->sum('amount');
        $data['fulfilled_orders'] = '0';
        $data['pending_fulfilled_orders'] = '0';
        return response(view('proxy.dashboard', $data))->header('Content-Type', 'application/liquid');
    }
    public function index(Request $request)
    {
        $seller = SellerService::getSeller();
        // echo $seller->token;
        $vendors = Vendor::where('seller_id', SellerService::getSellerId())
            ->orderBy('id', 'DESC')
            ->paginate(10)
            ->appends($request->query());
        // file_put_contents('vendors.txt', count($vendors));
        $pageTitle = "Vendors";
        $routeType = RouteTypeEnum::VENDOR;

        return view('app.vendors.index', compact(
            'pageTitle',
            'routeType',
            'vendors'
        ));
    }
    public function createByProxy()
    {
        $data = $this->getProxyData();
        $data['pageTitle'] = trans('general.register_new_vendor');
        // return response()->header('Content-Type', 'application/liquid');
        return response(view('proxy.vendors.create-new', $data))->header('Content-Type', 'application/liquid');
    }
    public function editByProxy()
    {
        $data = $this->getProxyData();
        $data['pageTitle'] = trans('general.manage_profile');
        return response(view('proxy.vendors.edit', $data))->header('Content-Type', 'application/liquid');
    }
    public function storeByProxy(Request $request): JsonResponse
    {
        $seller_id = $request->input('seller_id');
        $seller = SellerService::findById($seller_id);
        $rules = [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(TableEnum::VENDORS)->where(function ($query) use ($seller_id) {
                    $query->where('seller_id', $seller_id);
                }),
            ]
        ];
        if ($request->has('password')) {
            $rules['password'] = 'required|string|min:6|confirmed';
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        if ($request->has('customer_id')) {
            VendorService::updateProxyVendor();
        } else {
            $customerRequest = ShopifyService::call(
                $seller->token,
                $seller->domain,
                ShopifyEndPointEnum::CUSTOMERS,
                CustomerService::getCustomerQuery(),
                MethodEnum::POST
            );
            $customerResponse = json_decode($customerRequest['response'], true);
            if (isset($customerResponse['customer'])) {
                $apiCustomer = $customerResponse['customer'];
                $apiCustomer['phone'] = request()->input('phone');
                $customer = CustomerService::manage($seller, $apiCustomer);
                $vendor = VendorService::updateProxyVendor();
                $vendor->customer_id = $customer->id;
                if ($seller->setting->vendor_auto_approval) {
                    $vendor->approved = ApprovedStatusEnum::APPROVED;
                }
                $vendor->save();
            } else {
                if (isset($customerResponse['errors'])) {
                    return response()->json([
                        'success' => false,
                        'errors' => $customerResponse['errors']
                    ]);
                }
            }
        }

        // Mail::to($vendor->email)->send(new VendorRegister($vendor));

        Mail::to('lamarwane998@gmail.com')->send(new AdminNotification($vendor));

        return response()->json([
            'success' => true,
            'customer' => $customer
        ]);
    }
    public function updateByProxy(Request $request, $id)
    {
        $seller_id = $request->input('seller_id');
        $seller = SellerService::findById($seller_id);

        $customer_id = $request->input('customer_id');
        $customer = CustomerService::findById($customer_id);

        $vendor = VendorService::findById($id);

        $fieldFor = $request->input('fieldFor');
        if ($fieldFor == 'create') {
            $rules = ['email' => 'required|string|email|max:255|unique:' . TableEnum::VENDORS . ',email,' . $id];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
        }
        $customerQuery = CustomerService::getCustomerQuery($vendor);
        $customerRequest = ShopifyService::call(
            $seller->token,
            $seller->domain,
            ShopifyEndPointEnum::CUSTOMERS . "/" . $customer->customer_id,
            $customerQuery,
            MethodEnum::PUT
        );
        $customerResponse = json_decode($customerRequest['response'], true);
        if (isset($customerResponse['customer'])) {
            $apiCustomer = $customerResponse['customer'];
            $customer = CustomerService::manage($seller, $apiCustomer);
            $vendor = VendorService::updateProxyVendor($vendor);
            if ($fieldFor == 'update') {
                $name = request()->input('name');
                $nameArray = explode(' ', $name);
                $customerAddress = $customer->addresses[0];
                $addressId = $customerAddress['id'];
                $addressQuery = [
                    'address' => [
                        'id' => $addressId,
                        "first_name" => $nameArray[0],
                        "last_name" => $nameArray[1],
                        "name" => $name,
                        "phone" => $request->input('phone'),
                        "address1" => $request->input('address1'),
                        "address2" => $request->input('address2'),
                        "city" => $request->input('city'),
                        "province" => $request->input('province'),
                        "zip" => $request->input('zip'),
                        "country" => $request->input('country')
                    ]
                ];
                $customerAddressEndPoint = str_replace(['customer_Id', 'address_id'], [$customer->customer_id, $addressId], ShopifyEndPointEnum::CUSTOMER_ADDRESSES);
                ShopifyService::call(
                    $seller->token,
                    $seller->domain,
                    $customerAddressEndPoint,
                    $addressQuery,
                    MethodEnum::PUT
                );
                return response()->json([
                    'success' => true,
                    'customer' => $customer
                ]);
            }
        } else {
            $errors = $customerResponse['errors'];
            return response()->json(['success' => false, 'errors' => $errors]);
        }
    }
    public function show(Request $request, $vendorId)
    {
        $vendor = VendorService::findById($vendorId);
        $pageTitle = "Detail of " . $vendor->name;
        $routeType = RouteTypeEnum::VENDOR;
        return view('app.vendors.show', compact(
            'pageTitle',
            'routeType',
            'vendor'
        ));
    }

    public function addPayout(Request $request)
    {
        $vendor = Vendor::find($request->input('vendor_id'));
        $vendor->payout_paypal = $request->input('paypal');
    }

    /**
     * Remove the specified resource from storage
     */
    public function destroy(Vendor $vendor)
    {
        $custom_delete = 1;
        if (!empty($vendor->customer)) {
            $customer = $vendor->customer;
            $seller = SellerService::findById($customer->seller_id);
            $customerRequest = ShopifyService::call(
                $seller->token,
                $seller->domain,
                ShopifyEndPointEnum::CUSTOMERS . "/" . $customer->customer_id,
                [],
                MethodEnum::DELETE
            );
            $customerResponse = json_decode($customerRequest['response'], true);
            if (!empty($customerResponse)) {
                $custom_delete = 0;
            }
        }
        if ($custom_delete) {
            $vendor->delete();
            return response()->json([
                'success' => true,
                'message' => "Successfully Deleted"
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => "Something went wrong. try again later",
                'response' => $customerResponse ?? []
            ]);
        }
    }
}
