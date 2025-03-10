<?php

declare(strict_types=1);

namespace App\Enum;

class TransactionTypeEnum extends AbstractEnum
{

    public const SALE = 'sale';
    public const REFUND = 'refund';
    public const WITHDRAWAL = 'withdrawal';

    public static function getValues(): array
    {
        return array(
            self::SALE,
            self::REFUND,
            self::WITHDRAWAL,
        );
    }

    public static function getTranslationKeys(): array
    {
        return array(
            // keys
        );
    }
}
