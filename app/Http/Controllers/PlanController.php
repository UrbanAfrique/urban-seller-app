<?php

namespace App\Http\Controllers;

use App\Enum\RouteTypeEnum;
use App\Enum\TransactionTypeEnum;
use App\Models\PayoutMethod;
use App\Models\Transaction;
use App\Models\Vendor;
use App\Traits\General;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use \Stripe\Stripe;
use App\Services\CustomerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class PlanController extends Controller
{
    use General;
    
    public function createByProxy(Request $request){        
        $customerId = $request->get('customerId');
        $customer = CustomerService::findById($customerId);
        
        if(empty($customer)){
            $data = $this->getProxyData();
            $seller = $data['seller'];
            return redirect()->to('https://' . $seller->domain . '/a/seller');
        }
        
        $productId = "prod_QsVeGk8AvRVgX2"; // "prod_QN0gwIP7NBH7ml";
        // $planId = "price_1PWGf2ELoRkNALZzN5zxpGxw";
        $planId = "price_1Q0kdJLjN2qJj4Df6hlS27pn";  // live key
        
        $key = config('services.stripe.secret');
        $stripe = new \Stripe\StripeClient($key);
        $plan = $stripe->plans->retrieve($planId, []);
        $prod = $stripe->products->retrieve(
               $plan->product,[]
           );
        $plan->product = $prod;
        $price = $plan->amount / 100;
        $data=[
            'pageTitle'=>$plan->product->name."($".$price."/m)",
            'customerId'=>$customerId,
            'planId'=>$planId,
            'intent' => $customer->createSetupIntent()
        ];
        
        return response(view('proxy.payout', $data))->header('Content-Type', 'application/liquid');
    }
    
        public function storeByProxy(Request $request)
        {
            
            $customerId = $request->input('customerId');
            // Step 3: Find customer by ID
            $customer = CustomerService::findById($customerId);
            // Step 4: Create or get Stripe customer
            $customer->createOrGetStripeCustomer();
            dd([
                'step' => 'stripe_customer_created',
                'stripe_id' => $customer->stripe_id
            ]);

            $paymentMethod = $request->input('paymentMethod');
            dd([
                'step' => 'payment_method_received',
                'paymentMethod' => $paymentMethod
            ]);

            // Step 5: Add payment method
            $customer->addPaymentMethod($paymentMethod);
            dd([
                'step' => 'payment_method_added'
            ]);

            $planId = $request->input('planId');
            dd([
                'step' => 'planId_received',
                'planId' => $planId
            ]);

            // Step 6: Create subscription
            $customer->newSubscription('default', $planId)
                ->trialDays(180)
                ->create($paymentMethod, [
                    'email' => $customer->email
                ]);
            dd([
                'step' => 'subscription_created'
            ]);

            // Step 7: Redirect after success
            return redirect()->to('https://' . $customer->seller->domain . '/a/seller');
        }



    
     public function subscriptions(Request $request){
        $data = $this->getProxyData();
        $data = $this->getProxyData();
        $vendor = $data['vendor'];
        $customer = $data['vendor']->customer;
        
        $key = config('services.stripe.secret');
        $stripe = new \Stripe\StripeClient($key);
        
        $customerId = $customer->stripe_id; 
        
        $subscriptions = $stripe->subscriptions->all(['customer' =>$customerId]);
        $data=[
            'pageTitle'=>"All Subscriptions",
            'subscriptions'=>$subscriptions,
            'routeName' =>'proxy.subscriptions'
        ];
        return response(view('proxy.subscriptions', $data))->header('Content-Type', 'application/liquid'); 
        
     }
}
