<?php

namespace App\Models;

use App\Enum\TableEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WebHook extends Model
{

    protected $table = TableEnum::WEBHOOKS;
    protected $fillable = [
        'seller_id',
        'name',
        'web_hook_id',
        'address'
    ];

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }
}
