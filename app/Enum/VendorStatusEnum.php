<?php

declare(strict_types=1);

namespace App\Enum;

class VendorStatusEnum extends AbstractEnum
{
    public const PENDING_APPROVAL = 'pending_approval';
    public const APPROVED = 'approved';
    public const NOT_APPROVED = 'not_approved';

    public static function getValues(): array
    {
        return array(
            self::PENDING_APPROVAL,
            self::APPROVED,
            self::NOT_APPROVED
        );
    }

    public static function getTranslationKeys(): array
    {
        return array(
            self::PENDING_APPROVAL => 'Pending Approval',
            self::APPROVED => 'Approved',
            self::NOT_APPROVED => 'Not Approved'
        );
    }
}
