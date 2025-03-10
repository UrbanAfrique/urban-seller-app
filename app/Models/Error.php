<?php

namespace App\Models;

use App\Enum\TableEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Error extends Model
{

    protected $table = TableEnum::ERRORS;
    protected $fillable = [
        'seller_id',
        'vendor_id',
        'type',
        'message'
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }
}
