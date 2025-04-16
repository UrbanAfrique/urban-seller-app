<?php

namespace App\Traits;

use App\Enum\RoutePrefixTypeEnum;
use App\Enum\VendorTypeEnum;
use App\Models\Vendor;
use App\Services\CustomerService;
use App\Services\SellerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

trait General
{
    public static function makeDirectory($name): void
    {
        $dirPath = public_path('uploads/' . $name);
        if (!file_exists($dirPath)) {
            if (!mkdir($dirPath, 0777, true) && !is_dir($dirPath)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $dirPath));
            }
        }
    }

    public function makeMultipleDirectories($parent, $children = array()): void
    {
        foreach ($children as $child) {
            $dirPath = public_path('images/' . $parent . "/" . $child);
            if (!file_exists($dirPath)) {
                if (!mkdir($dirPath, 0777, true) && !is_dir($dirPath)) {
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $dirPath));
                }
            }
        }
    }

    public static function generateFileName($file): string
    {
        $avatarNameWithExt = $file->getClientOriginalName();
        $avatarName = pathinfo($avatarNameWithExt, PATHINFO_FILENAME);
        $avatarName = preg_replace("/[^A-Za-z0-9 ]/", '', $avatarName);
        $avatarName = preg_replace("/\s+/", '-', $avatarName);
        $avatarExtension = $file->getClientOriginalExtension();
        return $avatarName . '_' . time() . '.' . $avatarExtension;
    }

    public function getParameterValue($query, $parameterName)
    {
        $parts = explode('&', $query);
        foreach ($parts as $part) {
            $new_pairs = explode('=', $part);
            if (count($new_pairs) > 1) {
                list($name, $value) = $new_pairs;
                if ($name === $parameterName) {
                    return $value;
                }
            } else {
                return null;
            }
        }
        return null;
    }

    public function getProxyData(): array
    {
        $query = $_SERVER['QUERY_STRING'];
        $domain = $this->getParameterValue($query, 'shop');
        $customerId = $this->getParameterValue($query, 'logged_in_customer_id');
        $proxy = $this->getParameterValue($query, 'path_prefix');
        
        $seller = SellerService::findByDomain($domain);
        $routeName = Route::currentRouteName();
        $data = [
            'seller' => $seller,
            'customerId' => $customerId,
            'domain' => $domain,
            'shop_domain' => $domain,
            'routeName' => $routeName, 
            'proxy' => !empty($proxy)
        ];
        if ($seller) {
            $dbCustomer = CustomerService::getLoggedInCustomer($customerId, $seller->id);
            if ($dbCustomer) {
                $data['vendor'] = Vendor::with('customer')
                    ->where('customer_id', $dbCustomer->id)
                    ->where('vendor_type', VendorTypeEnum::VENDOR)
                    ->first();
            }
            $data['customer'] = $dbCustomer;
        }
        return $data;
    }
    public function isProxyRequest(Request $request): bool
    {
        $prefix = $request->route()->getPrefix();
        // return $prefix == RoutePrefixTypeEnum::PROXY;
        return $request->has('path_prefix');
    }
}
