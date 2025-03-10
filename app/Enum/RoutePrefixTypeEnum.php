<?php

declare(strict_types=1);

namespace App\Enum;

class RoutePrefixTypeEnum extends AbstractEnum
{
    public const APP = '/app';
    public const PROXY = '/proxy';

    public static function getValues(): array
    {
        return array(
            self::APP,
            self::PROXY
        );
    }

    public static function getTranslationKeys(): array
    {
        return array(
            self::APP => 'App',
            self::PROXY => 'Proxy'
        );
    }
}
