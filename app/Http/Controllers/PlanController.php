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
            $CUST1 = $customer->createOrGetStripeCustomer();

            $paymentMethod = $request->input('paymentMethod');

            // Step 5: Add payment method
            $CUST2 =$customer->addPaymentMethod($paymentMethod);
            

            $planId = $request->input('planId');
            

            // Step 6: Create subscription
            $CUST3 = $customer->newSubscription('default', $planId)
                ->trialDays(180)
                ->create($paymentMethod, [
                    'email' => $customer->email
                ]);
            dd([
                'step' => 'createOrGetStripeCustomer',
                 '$CUST1' => $CUST1,
                 'step' => 'payment_method_added',
                 '$CUST2' => $CUST2,
                'step2' => 'subscription_created',
                '$CUST3' => $CUST3
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
