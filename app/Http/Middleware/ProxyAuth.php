<?php

namespace App\Http\Middleware;

use App\Traits\General;
use Closure;
use Illuminate\Support\Facades\Route;

class ProxyAuth
{
    use General;

    public function handle($request, Closure $next)
    {
        $proxyData = $this->getProxyData();
        $routeName = Route::currentRouteName();
        $checkroutes = [
            'proxy.dashboard',
            'proxy.products.index',
            'proxy.products.create',
            'proxy.products.show',
            'proxy.products.edit',
            'proxy.orders.index',
            'proxy.orders.show',
            'proxy.orders.fulfill',
            'proxy.profile',
            'proxy.balance.index',
        ];
        if (!isset($proxyData['customer']) && in_array($routeName, $checkroutes)) {
            return redirect()->to("https://" . $proxyData['domain'] . "/a/seller/account");
        }
        if (isset($proxyData['customer']) && $routeName == 'proxy.account') {
            return redirect()->to("https://" . $proxyData['domain'] . "/a/seller");
        }

        return $next($request);
    }
}
