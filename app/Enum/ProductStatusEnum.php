<?php

declare(strict_types=1);

namespace App\Enum;


class ProductStatusEnum extends AbstractEnum
{

    public const ACTIVE = 'active';
    public const ARCHIVED = 'archived';
    public const DRAFT = 'draft';

    public static function getValues(): array
    {
        return array(
            self::ACTIVE,
            self::ARCHIVED,
            self::DRAFT
        );
    }

    public static function getTranslationKeys(): array
    {
        return array(
            self::DRAFT => 'Draft',
            self::ACTIVE => 'Active'
        );
    }
}
