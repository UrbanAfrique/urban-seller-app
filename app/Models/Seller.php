<?php

namespace App\Models;

use App\Enum\TableEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Seller extends Model
{
    protected $table = TableEnum::SELLERS;
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    protected $fillable = [
        'store_id',
        'name',
        'owner',
        'domain',
        'primary_location_id',
        'primary_locale',
        'first_name',
        'last_name',
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
        'currency',
        'money_format',
        'hmac',
        'token',
        'term_of_use',
        'privacy_policy',
        'created_at',
        'updated_at'
    ];

    public function vendors(): HasMany
    {
        return $this->hasMany(Vendor::class);
    }

    public function setting(): HasOne
    {
        return $this->hasOne(Setting::class, 'seller_id');
    }

    public function scopeTermOfUse(Builder $query): Builder
    {
        return $query->where('term_of_use', true);
    }

    public function scopePrivacyPolicy(Builder $query): Builder
    {
        return $query->where('privacy_policy', true);
    }
}
