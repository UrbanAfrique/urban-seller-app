<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function store(Request $request)
    {
        $name = $request->input('role_name', null);
        $shop_id = $request->input('shop_id', null);
        $model = Role::updateOrCreate(
            [
                'shop_id' => $shop_id
            ],
            [
                'name' => $name
            ]
        );
        if ($model) {
            return response()->json([
                'status' => true
            ]);
        }
    }
}
