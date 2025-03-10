<?php

namespace App\Models;

use App\Enum\TableEnum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Setting extends Model
{


    protected $table = TableEnum::SETTINGS;

    protected $fillable = [
        'seller_id',
        'vendor_auto_approval',
        'product_auto_approval',
        'product_status'
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }
}
