<?php

namespace App\Http\Middleware;

use Closure;

class FrameHeadersMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $shop = $request->get('shop');
        if (!empty($shop))
            $response->header('Content-Security-Policy', 'frame-ancestors https://admin.shopify.com https://' . $shop);
        return $response;
    }
}
