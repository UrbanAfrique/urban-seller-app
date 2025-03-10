<?php

namespace App\Services;

use App\Enum\MethodEnum;

class ShopifyService
{

    public static function call(
        $token,
        $shop,
        $api_endpoint,
        $query = array(),
        $method = MethodEnum::GET,
        $headers = []
    ) {
        $url = "https://" . $shop . "/admin/api/" . env('SHOPIFY_API_VERSION') . "/" . $api_endpoint . ".json";
        if (!is_null($query) && in_array($method, array('GET', 'DELETE'))) $url = $url . "?" . http_build_query($query);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, TRUE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_USERAGENT, 'My New ShopifyService App v.1');
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

        if (in_array($method, array('POST', 'PUT'))) {
            $headers[] =  'Content-Type: application/json';
            // if ($api_endpoint != 'graphql')
                $query = json_encode($query);
        } else {
            $query = array();
        }
        if (!is_null($token)) $headers[] = "X-Shopify-Access-Token: " . $token;
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        if ($method != 'GET' && in_array($method, array('POST', 'PUT'))) {
            if (is_array($query)) $query = http_build_query($query);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $query);
        }
        $response = curl_exec($curl);
        $error_number = curl_errno($curl);
        $error_message = curl_error($curl);
        curl_close($curl);
        if ($error_number) {
            return $error_message;
        } else {
            $response = preg_split("/\r\n\r\n|\n\n|\r\r/", $response, 2);
            $headers = array();
            $header_data = explode("\n", $response[0]);
            $headers['status'] = $header_data[0];
            array_shift($header_data);
            foreach ($header_data as $part) {
                $h = explode(":", $part, 2);
                $headers[trim($h[0])] = trim($h[1]);
            }
            return array('headers' => $headers, 'response' => $response[1]);
        }
    }

    public static function graphql($shop, $params)
    {
        return self::call(
            $shop->token,
            $shop->domain,
            'graphql',
            $params,
            MethodEnum::POST
        );
    }

    public static function count($store, $type)
    {
        $request = self::call($store->token, $store->domain, 'count', null);
        return json_decode($request['response'], JSON_PRETTY_PRINT)['count'];
    }
}
