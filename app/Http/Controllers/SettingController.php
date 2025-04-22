<?php

namespace App\Http\Controllers;

use App\Enum\RouteTypeEnum;
use App\Services\SellerService;
use App\Services\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $seller = SellerService::getSeller();
        $routeType = RouteTypeEnum::SETTING;
        $pageTitle = 'Manage Settings';
        $setting = $seller->setting;
        dd($seller);
        return \view('app.settings.index', compact(
            'routeType',
            'setting',
            'pageTitle'
        ));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $setting = SettingService::findById($id);
        SettingService::updateSetting($setting);
        return redirect()->route('app.settings.index', [
            'shop' => SellerService::getSellerDomain(),
            'timestamp' => time(),
            'success' => true,
            'successMessage' => 'Setting updated Successfully'
        ]);
    }
}
