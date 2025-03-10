<?php


declare(strict_types=1);

namespace App\Enum;

class TableEnum extends AbstractEnum
{

    public const SELLERS = 'sellers';
    public const WEBHOOKS = 'webhooks';
    public const CUSTOMERS = 'customers';
    public const ORDERS = 'orders';
    public const ORDER_ITEMS = 'order_items';
    public const ORDER_CUSTOMERS = 'order_customers';
    public const ORDER_BILLING_ADDRESSES = 'order_billing_addresses';
    public const ORDER_SHIPPING_ADDRESSES = 'order_shipping_addresses';
    public const SETTINGS = 'settings';
    public const JOBS = 'jobs';
    public const FAILED_JOBS = 'failed_jobs';
    public const COUNTRIES = 'countries';
    public const STATES = 'states';
    public const CITIES = 'cities';
    public const USERS = 'users';
    public const CATEGORIES = 'categories';
    public const PRODUCTS = 'products';
    public const VARIANTS = 'variants';
    public const VENDORS = 'vendors';
    public const ERRORS = 'errors';
    public const CUSTOM_COLLECTIONS = 'custom_collections';

    public static function getValues(): array
    {
        return [
        ];
    }

    public static function getTranslationKeys(): array
    {
        return [

        ];
    }
}
