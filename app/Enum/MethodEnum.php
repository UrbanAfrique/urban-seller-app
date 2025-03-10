<?php

declare(strict_types=1);

namespace App\Enum;
class MethodEnum extends AbstractEnum
{
    public const GET = 'GET';
    public const POST = 'POST';
    public const PUT = 'PUT';
    public const DELETE = 'DELETE';

    public static function getValues(): array
    {
        return array(
            self::GET,
            self::POST,
            self::PUT,
            self::DELETE
        );
    }

    public static function getTranslationKeys(): array
    {
        return array();
    }
}
