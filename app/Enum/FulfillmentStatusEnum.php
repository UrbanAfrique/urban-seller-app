<?php

declare(strict_types=1);

namespace App\Enum;

class FulfillmentStatusEnum extends AbstractEnum
{
    public const FUlFILLED = 'fulfilled';
    public const PARTIAL = 'partial';
    public const PENDING = 'pending';

    public static function getValues(): array
    {
        return array(
            self::FUlFILLED,
            self::PARTIAL
        );
    }

    public static function getTranslationKeys(): array
    {
        return array(
            self::FUlFILLED => 'Fulfilled',
            self::PARTIAL => 'Partial'
        );
    }
}
