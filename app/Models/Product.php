<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'seller_id',
        'vendor_id',
        'product_id',
        'vendor_product_id',
        'title',
        'handle',
        'product_type',
        'product_category',
        'product_vendor',
        'tags',
        'status',
        'body_html',
        'template_suffix',
        'published_scope',
        'image',
        'images',
        'site_url',
        'is_vendor_product',
        'collections',
        'published',
        'created_at',
        'updated_at',
        'published_at',
        'reject_reason', 

        'wholesale',
        'min_qty',
        'discount_type',
        'discount_value',
        'metafields',
        'discount_id',
    ];

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }
    public function getCollectionsAttribute($key)
    {
        return json_decode($key, true);
    }

    public function getImagesAttribute($key)
    {
        return json_decode($key, true);
    }

    public function getShopifyImagesAttribute($key)
    {
        return json_decode($key, true);
    }
}
