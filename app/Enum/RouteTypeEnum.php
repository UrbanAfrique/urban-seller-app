<?php

declare(strict_types=1);

namespace App\Enum;

class RouteTypeEnum extends AbstractEnum
{

    public const HOME = 'home';
    public const INSTALLATION = 'installation';
    public const VENDOR = 'vendor';
    public const SELLER = 'seller';
    public const SETTING = 'setting';
    public const PRODUCT = 'product';
    public const ORDER = 'order';
    public const WITHDRAWS = 'withdraws';
    public const ORDER_FULFILL = 'order_fulfill';
    public static function getValues(): array
    {
        return array(
            self::HOME,
            self::INSTALLATION,
            self::SELLER,
            self::SETTING,
            self::PRODUCT,
            self::ORDER
        );
    }

    public static function getTranslationKeys(): array
    {
        return array(
            self::HOME => 'Home',
            self::INSTALLATION => "Installation",
            self::VENDOR => "Vendor",
            self::SELLER => "Seller",
            self::SETTING => "Setting",
            self::PRODUCT => "Product",
            self::ORDER => "Order"
        );
    }

    public static function isActive($type): string
    {
        $url = request()->fullUrl();
        if (strpos($url, $type) !== false) {
            return "inactive";
        } else {
            return "active";
        }
    }
}
