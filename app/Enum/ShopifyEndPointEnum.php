<?php

declare(strict_types=1);

namespace App\Enum;

class ShopifyEndPointEnum extends AbstractEnum
{
    public const PRODUCTS = 'products';
    public const VARIANTS = 'variants';
    public const WEBHOOKS = 'webhooks';
    public const SHOP = 'shop';
    public const ORDERS = 'orders';
    public const SCRIPT_TAGS = 'script_tags';
    public const CUSTOMERS = 'customers';
    public const CUSTOM_COLLECTIONS = 'custom_collections';
    public const COLLECTS = 'collects';
    public const CUSTOMER_ADDRESSES = 'customers/customer_Id/addresses/address_id';
    public static function getValues(): array
    {
        return array();
    }

    public static function getTranslationKeys(): array
    {
        return array();
    }
}
