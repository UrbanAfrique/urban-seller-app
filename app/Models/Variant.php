<?php

namespace App\Models;

use App\Enum\TableEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Variant extends Model
{
    protected $table = TableEnum::VARIANTS;
    protected $fillable = [
        'product_id',
        'variant_id',
        'title',
        'sku',
        'price',
        'compare_at_price',
        'position',
        'inventory_policy',
        'fulfillment_service',
        'inventory_management',
        'option1',
        'option2',
        'option3',
        'taxable',
        'barcode',
        'weight',
        'weight_unit',
        'inventory_item_id',
        'inventory_quantity',
        'old_inventory_quantity',
        'requires_shipping',
        'image',
        'created_at',
        'updated_at'
    ];
    protected $dates = [
        'created_at', 'updated_at'
    ];
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
