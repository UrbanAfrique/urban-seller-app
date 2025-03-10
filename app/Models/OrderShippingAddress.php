<?php

namespace App\Models;

use App\Enum\TableEnum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderShippingAddress extends Model
{

    protected $table = TableEnum::ORDER_SHIPPING_ADDRESSES;
    protected $fillable = [
        'order_id',
        'name',
        'phone',
        'company',
        'address1',
        'address2',
        'city',
        'province',
        'province_code',
        'country',
        'country_code',
        'zip',
        'latitude',
        'longitude'
    ];
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
