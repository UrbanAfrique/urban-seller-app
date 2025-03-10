<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayoutMethod extends Model
{
    protected $fillable = [
        'seller_id',
        'vendor_id',
        'type',
        'account',
        'account_title',
        'swiftcode',
        'address',
    ];
}
