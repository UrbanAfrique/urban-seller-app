<?php

declare(strict_types=1);

namespace App\Enum;

use App\Services\ShopifyService;

class RoleEnum extends AbstractEnum
{

    public const VENDOR = 'vendor';
    public const SELLER = 'seller';

    public static function getValues(): array
    {
        return array(
            self::VENDOR,
            self::SELLER
        );
    }

    public static function getTranslationKeys(): array
    {
        return array(
            self::VENDOR => 'Vendor',
            self::SELLER => 'Seller'
        );
    }
}
