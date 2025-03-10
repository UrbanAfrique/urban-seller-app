<?php

declare(strict_types=1);

namespace App\Enum;

class VendorTypeEnum extends AbstractEnum
{

    public const SHOP = 'shop';
    public const VENDOR = 'vendor';

    public static function getValues(): array
    {
        return array(
            self::SHOP,
            self::VENDOR
        );
    }

    public static function getTranslationKeys(): array
    {
        return array(
            self::SHOP => 'Shop',
            self::VENDOR => 'Vendor'
        );
    }
}
