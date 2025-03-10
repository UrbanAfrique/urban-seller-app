<?php

namespace App\Models;

use App\Enum\TableEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Cashier\Billable;
class Customer extends Model
{
    use Billable;
    protected $table = TableEnum::CUSTOMERS;
    protected $fillable = [
        'seller_id',
        'customer_id',
        'email',
        'accepts_marketing',
        'first_name',
        'last_name',
        'orders_count',
        'state',
        'total_spent',
        'last_order_id',
        'last_order_name',
        'verified_email',
        'multipass_identifier',
        'tax_exempt',
        'tags',
        'currency',
        'phone',
        'accepts_marketing_updated_at',
        'marketing_opt_in_level',
        'admin_graphql_api_id',
        'default_address',
        'addresses',
        'note',
        'tax_exemptions',
        'email_marketing_consent',
        'sms_marketing_consent',
        'created_at',
        'updated_at'
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
    public function vendor(): HasOne
    {
        return $this->hasOne(Vendor::class);
    }
    public function getDefaultAddressAttribute($key)
    {
        return json_decode($key, true);
    }
    public function getAddressesAttribute($key)
    {
        return json_decode($key, true);
    }
}
