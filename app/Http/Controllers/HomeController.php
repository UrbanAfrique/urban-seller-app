<?php

namespace App\Http\Controllers;

use App\Enum\RoleEnum;
use App\Enum\RouteTypeEnum;
use App\Enum\ShopifyEndPointEnum;
use App\Models\Seller;
use App\Services\CustomCollectionService;
use App\Services\CustomerService;
use App\Services\SellerService;
use App\Services\SettingService;
use App\Services\ShopifyService;
use App\Services\WebhookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $seller = SellerService::getSeller();
        $install = false;
        //dd('index 0', $request, $seller);
        if (!empty($seller)) {
            //dd('index', $seller);
            $response = ShopifyService::call(
                $seller->token,
                $seller->domain,
                ShopifyEndPointEnum::WEBHOOKS
            );
            if (!empty($response['error'])) {
                $install = true;
            } else {
                $hooks = json_decode($response['response'], JSON_PRETTY_PRINT);
                if (!empty($hooks['errors']) && $hooks['errors'] == '[API] Invalid API key or access token (unrecognized login or wrong password)') {
                    $install = true;
                }
            }
        }
        if ($seller && !$install) {
            //dd('index 2', $seller);
            WebhookService::manage(
                $seller->token,
                $seller->domain,
                RoleEnum::SELLER,
                $seller->id);

            $store = str_replace(".myshopify.com", "", $seller->domain);
            if ($request->has('session')) {
                return redirect()->route('app.vendors.index', ['shop' => $seller->domain, 'timestamp' => time()]);
                if ($seller->term_of_use && $seller->privacy_policy) {
                    // 
                } else {
                    $routeType = RouteTypeEnum::INSTALLATION;
                    $pageTitle = 'Verify Your Email Address';
                    return \view('app.installation.index', compact(
                        'routeType',
                        'seller',
                        'pageTitle'
                    ));
                }
            } else {
                $return_url = 'https://admin.shopify.com/store/' . $store . "/apps/" . config('services.shopify.app_name');
                header("Location: " . $return_url);
                die();
            }
        } 
        else {
            //dd('index 3');
            $domain = $request->query('shop');
            $hmac = $request->query('hmac');
            $timestamp = $request->query('timestamp');
            return redirect()->route('app.install', [
                'hmac' => $hmac,
                'shop' => $domain,
                'timestamp' => $timestamp
            ]);
        }
    }

    public function install(Request $request)
    {
        //dd('install');
        $domain = $request->get('shop', null);
        $hMac = $request->get('hmac', null);
        $install_url = "https://" . $domain . "/admin/oauth/authorize?client_id=" . config('services.shopify.api_key') . "&scope=" . trim(config('services.shopify.scopes')) . "&redirect_uri=" . urlencode(route('app.token'));
        Seller::updateOrCreate([
            'domain' => $domain
        ], [
            'hmac' => $hMac
        ]);
        header("Location: " . $install_url);
        die();
    }

    public function token(Request $request)
    {
        $params = $_GET;
        $hmac = $_GET['hmac'];
        $code = $_GET['code'];
        $params = array_diff_key((array)$params, array('hmac' => ''));
        ksort($params);
        $computed_hmac = hash_hmac('sha256', http_build_query($params),  config('services.shopify.api_secret'));
        if (hash_equals($hmac, $computed_hmac)) {
            $domain = $request->query('shop', null);
            $result = $this->getAccessToken($domain, $code);
            $seller = SellerService::getSellerByDomain($domain);
            $seller->token = $result['access_token'];
            $seller->save();
            $sellerModel = SellerService::sync($seller);


            SettingService::saveDefaultSellerSettings($sellerModel);
            // CustomerService::syncAll($seller);
            // CustomCollectionService::syncAll($seller);
            // Artisan::call('sync:countries');
            // Artisan::call('sync:custom-collections');
            // Artisan::call('sync:customers');

            $return_url = 'https://' . $domain . "/admin/apps/" .  config('services.shopify.app_name');
            header("Location: " . $return_url);
            die();
        } else {
            die('This request is NOT from Shopify!');
        }
    }

    public function getAccessToken($shop, $code)
    {
        $query = array(
            "client_id" => config('services.shopify.api_key'),
            "client_secret" => config('services.shopify.api_secret'),
            "code" => $code
        );
        $access_token_url = "https://" . $shop . "/admin/oauth/access_token";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $access_token_url);
        curl_setopt($ch, CURLOPT_POST, count($query));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query));
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }
}
