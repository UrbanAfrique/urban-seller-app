<?php

namespace App\Services;

use App\Enum\ApprovedStatusEnum;
use App\Enum\VendorTypeEnum;
use App\Models\Vendor;

class VendorService
{
    public static function getApprovedHtml($vendor, $type = 'proxy'): string
    {
        $html = "";

        switch ($vendor->approved) {
            case ApprovedStatusEnum::APPROVED:
                $buttonClass = $type == 'proxy' ? 'w3-btn w3-tiny w3-green' : 'btn btn-sm btn-success';
                $status = ApprovedStatusEnum::getTranslationKeyBy(ApprovedStatusEnum::APPROVED);
                $html .= '<span class="' . $buttonClass . '">' . $status . '</span>';
                break;

            case ApprovedStatusEnum::PENDING:
                $buttonClass = $type == 'proxy' ? 'w3-btn w3-tiny w3-yellow' : 'btn btn-sm btn-warning';
                $status = ApprovedStatusEnum::getTranslationKeyBy(ApprovedStatusEnum::PENDING);
                $html .= '<span class="' . $buttonClass . '">' . $status . '</span>';
                break;

            case ApprovedStatusEnum::REJECTED:
                $buttonClass = $type == 'proxy' ? 'w3-btn w3-tiny w3-red' : 'btn btn-sm btn-danger';
                $status = ApprovedStatusEnum::getTranslationKeyBy(ApprovedStatusEnum::REJECTED);

                if ($type == 'app') {
                    $html .= '<span class="' . $buttonClass . '">' . $status . '</span>';
                    $html .= '<span class="btn btn-sm" role="button" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="' . $vendor->reject_reason . '"><i class="fa fa-eye"></i></span>';
                }
                break;
        }

        return $html;
    }

    public static function getAccountHtml($payout){
        if(empty($payout)) return '-';
        if($payout->type == 'bank'){
            $html = '<img src="'.asset('images/icons/'.$payout->type.'-icon.png').'" width="20" /> ' . $payout->account;
            $account = 'Title: '.$payout->type . "\n" . 
                        'Number: '.$payout->account . "\n" . 
                        'Swiftcode: '.$payout->swiftcode . "\n" . 
                        'Address: '.$payout->address;

            $html .= '<span class="btn btn-sm" role="button" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="'.$account.'"><i class="fa fa-eye"></i></span>';
        } else {
            $html = '<img src="'.asset('images/icons/paypal-icon.png').'" width="20" />' . $payout->account;
        }
        return $html;
    }


    public static function findById($vendorId)
    {
        return Vendor::with('customer')->find($vendorId);
    }

    public static function pluckVendors()
    {
        return Vendor::pluck('domain', 'id');
    }

    public static function findByDomain($domain)
    {
        return Vendor::whereDomain($domain)->first();
    }

    public static function updateProxyVendor($vendor = null): Vendor
    {
        $vendor = ($vendor) ?? new Vendor();
        $vendor->fill(request()->only([
            'customer_id',
            'seller_id',
            'domain',
            'name',
            'email',
            'phone',
            'tags',
            'address1',
            'address2',
            'country',
            'province',
            'city',
            'zip',
            'company'
        ]));
        $vendor->save();
        $vendor->vendor_type = VendorTypeEnum::VENDOR;
        $vendor->save();
        return $vendor;
    }

    public static function generateAddress($d): string
    {
        $address = "";
        if ($d->city) {
            $address .= ucwords($d->city) . ",";
        }
        if ($d->province) {
            $address .= ucwords($d->province) . ",";
        }
        if ($d->country) {
            $address .= ucwords($d->country);
        }
        return $address;
    }
}
