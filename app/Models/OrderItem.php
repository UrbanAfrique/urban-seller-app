<?php

namespace App\Models;

use App\Enum\TableEnum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{


    protected $table = TableEnum::ORDER_ITEMS;
    protected $fillable = [
        'seller_id',
        'order_id',
        'item_id',
        'product_id',
        'variant_id',
        'name',
        'quantity',
        'sku',
        'vendor',
        'fulfillment_service',
        'requires_shipping',
        'taxable',
        'grams',
        'price',
        'total_discount',
        'fulfillment_status',
        'fulfillable_quantity'
    ];
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
