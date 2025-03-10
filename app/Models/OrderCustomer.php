<?php

namespace App\Models;

use App\Enum\TableEnum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderCustomer extends Model
{


    protected $table = TableEnum::ORDER_CUSTOMERS;
    protected $fillable = [
        'order_id',
        'customer_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'tags',
        'orders_count',
        'state',
        'total_spent',
        'company',
        'address1',
        'address2',
        'city',
        'province',
        'country',
        'zip'
    ];
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
