<?php

namespace App\Models;

use App\Enum\FulfillmentStatusEnum;
use App\Enum\TableEnum;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{


    protected $table = TableEnum::ORDERS;
    protected $fillable = [
        'seller_id',
        'vendor_id',
        'order_id',
        'order_number',
        'order_name',
        'total_price',
        'subtotal_price',
        'total_weight',
        'total_tax',
        'currency',
        'financial_status',
        'fulfillment_status'
    ];

    public function getCreatedAtAttribute($key): string
    {
        $date = Carbon::parse($key);
        return $date->format('l') . " at " . $date->format('H:i a');
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function order_customer(): HasOne
    {
        return $this->hasOne(OrderCustomer::class);
    }
    public function order_billing_address(): HasOne
    {
        return $this->hasOne(OrderBillingAddress::class);
    }
    public function order_shipping_address(): HasOne
    {
        return $this->hasOne(OrderShippingAddress::class);
    }
    public function order_items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id',);
    }

    public function getOrderItemsTotalPrice()
    {
        return ($this->order_items->sum('price') * $this->order_items->sum('quantity')) - $this->order_items->sum('total_discount');
    }
    public function getOrderItemsTotal()
    {
        return $this->order_items->sum('quantity');
    }
    public function getOrderItemsFulfillmentStatus(): string
    {
        $fulfilled = [];
        if (count($this->order_items) > 0) {
            foreach ($this->order_items as $order_item) {
                $fulfilled[] = $order_item->fulfillment_status;
            }
        }

        if (count(array_unique($fulfilled)) === 1 && empty(reset($fulfilled)))
            return '';
        else if (count(array_unique($fulfilled)) === 1 && reset($fulfilled) === 'fulfilled')
            return FulfillmentStatusEnum::FUlFILLED;
        else
            return FulfillmentStatusEnum::PARTIAL;
    }

    public function getOrderItemsFulfillmentStatusWithButton(): string
    {
        $status = $this->getOrderItemsFulfillmentStatus();
        if ($status === FulfillmentStatusEnum::FUlFILLED) {
            return "<a class='w3-badge w3-green'>Fulfilled</a>";
        } else if ($status === FulfillmentStatusEnum::PARTIAL) {
            return "<a class='w3-badge w3-yellow'>Partial</a>";
        } else {
            return "<a class='w3-badge btn-blue'>Pending</a>";
        }
    }
}
