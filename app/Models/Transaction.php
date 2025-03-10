<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    // Specify the table name
    // protected $table = 'balance_history';

    // Specify the columns that are mass assignable
    protected $fillable = [
        'seller_id',
        'vendor_id',
        'type',
        'amount',
        'balance_after',
        'detail',
        'order_id',
        'status'
    ];

    public function getRejectReasonAttribute()
    {
        return $this->detail;
    }
    public function getApprovedAttribute()
    {
        return $this->status == null ? 'pending'  : ($this->status ? 'approved' : 'rejected');
    }

    // Define the relationship with the Vendor model (assuming you have a Vendor model)
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
