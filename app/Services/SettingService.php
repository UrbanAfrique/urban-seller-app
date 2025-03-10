<?php

namespace App\Services;

use App\Enum\ProductStatusEnum;
use App\Models\Setting;

class SettingService
{
    public static function findById($id)
    {
        return Setting::find($id);
    }

    public static function findBySellerId($seller_id)
    {
        return Setting::whereSellerId($seller_id)->first();
    }

    public static function saveDefaultSellerSettings($seller)
    {
        Setting::updateOrCreate([
            'seller_id' => $seller->id
        ], [
            'vendor_auto_approval' => false,
            'product_auto_approval' => false,
            'product_status' => ProductStatusEnum::DRAFT
        ]);
    }

    public static function updateSetting($setting)
    {
        $setting->update([
            'vendor_auto_approval' => request()->input('vendor_auto_approval'),
            'product_auto_approval' => request()->input('product_auto_approval'),
            'product_status' => request()->input('product_status')
        ]);
        return $setting;
    }
}
