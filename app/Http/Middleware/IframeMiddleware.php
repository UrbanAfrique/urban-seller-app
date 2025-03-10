<?php

namespace App\Http\Middleware;

use Closure;

class IframeMiddleware
{
    public function handle($request, Closure $next)
    {
        if (session('_previous')) {
            // Redirect to the external URL
            if($request->has('shop')){
                $store = str_replace(".myshopify.com", "", $request->get('shop'));
                $return_url = 'https://admin.shopify.com/store/' . $store . "/apps/" . env('SHOPIFY_APP_NAME');
                return redirect()->away($return_url);
            } else 
            return redirect()->away('https://admin.shopify.com/store');
        }

        return $next($request);
    }
}
