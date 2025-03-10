<?php

declare(strict_types=1);

namespace App\Enum;

use App\Services\SellerService;

class MenuEnum extends AbstractEnum
{

    public const SETTING = 'setting';
    public const PRODUCT = 'product';
    public const VENDOR = 'vendor';
    public const ORDER = 'order';
    public const WITHDRAWS = 'withdraws';

    public static function getValues(): array
    {
        return array(
            self::SETTING,
            self::VENDOR,
            self::PRODUCT,
            self::ORDER,
            self::WITHDRAWS
        );
    }

    public static function getRoute($key)
    {
        $routes = array(
            self::SETTING => route('app.settings.index', ['shop' => SellerService::getSellerDomain(), 'timestamp' => time()]),
            self::PRODUCT => route('app.products.index', ['shop' => SellerService::getSellerDomain(), 'timestamp' => time()]),
            self::VENDOR => route('app.vendors.index', ['shop' => SellerService::getSellerDomain(), 'timestamp' => time()]),
            self::ORDER => route('app.orders.index', ['shop' => SellerService::getSellerDomain(), 'timestamp' => time()]),
            self::WITHDRAWS => route('app.withdraws', ['shop' => SellerService::getSellerDomain(), 'timestamp' => time()]),
        );
        return $routes[$key] ?? route('home');
    }
    public static function getTranslationKeys(): array
    {
        return array(
            self::VENDOR  => "Vendors",
            self::PRODUCT => 'Products',
            self::ORDER   => "Orders",
            self::SETTING => 'Settings',
            self::WITHDRAWS => 'Withdraws'
        );
    }
}
