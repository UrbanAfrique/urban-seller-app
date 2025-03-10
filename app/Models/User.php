<?php

namespace App\Models;

use App\Enum\TableEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class User extends Model
{
    protected $table=TableEnum::USERS;
    protected $fillable=[
        'seller_id',
        'name',
        'email',
        'password',
        'bubble_user_id',
        'bubble_user_token',
        'bubble_user_expire',
        'credit_balance',
        'total_spent'
    ];
    public function shop(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }
}
