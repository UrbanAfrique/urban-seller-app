<?php

declare(strict_types=1);

namespace App\Enum;
class ApprovedStatusEnum extends AbstractEnum
{
    public const PENDING = 'pending';
    public const APPROVED = 'approved';
    public const REJECTED = 'rejected';

    public static function getValues(): array
    {
        return array(
            self::PENDING,
            self::APPROVED,
            self::REJECTED
        );
    }

    public static function getTranslationKeys(): array
    {
        return array(
            self::PENDING => trans('general.pending'),
            self::APPROVED => trans('general.approved'),
            self::REJECTED => trans('general.rejected')
        );
    }
}
