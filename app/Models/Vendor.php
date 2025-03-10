<?php

namespace App\Models;

use App\Enum\TableEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vendor extends Model
{
    protected $table = TableEnum::VENDORS;

    protected $fillable = [
        'seller_id',
        'customer_id',
        'name',
        'owner',
        'domain',
        'tags',
        'phone',
        'email',
        'country',
        'province',
        'city',
        'address1',
        'address2',
        'zip',
        'latitude',
        'longitude',
        'company',
        'vendor_type',
        'approved',
        'created_at',
        'updated_at',
        'reject_reason'
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function payout()
    {
        return $this->hasOne(PayoutMethod::class);
    }
}
