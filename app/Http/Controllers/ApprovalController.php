<?php

namespace App\Http\Controllers;
use App\Enum\ApprovedStatusEnum;
use App\Enum\VendorTypeEnum;
use App\Mail\VendorApproval;
use App\Models\Transaction;
use App\Services\ProductService;
use App\Services\SellerService;
use App\Services\VendorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ApprovalController extends Controller
{
    public function vendorApproval(Request $request): JsonResponse
    {
        $sellerDomain = SellerService::getSellerDomain();
        $vendor_id = $request->input('vendor_id');
        $approved = $request->input('approved');
        $vendor = VendorService::findById($vendor_id);
        $vendor->approved = $approved;
        if ($request->has('reject_reason')) {
            $vendor->reject_reason = $request->input('reject_reason');
        }
        $vendor->save();
        if ($vendor->approved == ApprovedStatusEnum::APPROVED) {
            $loginUrl = "https://" . $sellerDomain . "/a/seller";
            Mail::to($vendor->email)->send(new VendorApproval(ApprovedStatusEnum::APPROVED, $loginUrl,''));
        } else {
            Mail::to($vendor->email)->send(new VendorApproval(ApprovedStatusEnum::REJECTED, '',$vendor->reject_reason));
        }
        return response()->json([
            'success' => true,
            'action' => view('components.vendors.action', compact('vendor'))->render(),
            'approved' => VendorService::getApprovedHtml($vendor, 'app'),
        ]);
    }

    public function productApproval(Request $request): JsonResponse
    {
        $product_id = $request->input('product_id');
        $product = ProductService::findById($product_id);
        if ($product) {
            return ProductService::manageApproval($product);
        } else {
            return response()->json([
                'success' => false,
            ]);
        }
    }

    public function withdrawApproval(Request $request): JsonResponse
    {
        $transaction_id = $request->input('vendor_id'); 
        $transaction = Transaction::find($transaction_id);
        if ($transaction) {
            $transaction->status = $request->input('approved') == ApprovedStatusEnum::APPROVED ? 1 : 0;
            if ($request->has('reject_reason')) {
                $transaction->detail = $request->input('reject_reason');
            } else if($transaction->status){
                $transaction->detail = ApprovedStatusEnum::APPROVED;
            }
            $transaction->save();
            $transaction = Transaction::find($transaction_id);
            return response()->json([
                'success' => true,
                'action' => '', // view('components.vendors.action', compact('vendor'))->render(),
                'approved' => VendorService::getApprovedHtml($transaction, 'app'),
            ]);
        } else {
            return response()->json([
                'success' => false,
            ]);
        }
    }

    
}
