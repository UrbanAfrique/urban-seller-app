<?php

namespace App\Models;

use App\Enum\TableEnum;
use Illuminate\Database\Eloquent\Model;

class CustomCollection extends Model
{
    protected $table = TableEnum::CUSTOM_COLLECTIONS;
    protected $fillable = [
        'seller_id',
        'collection_id',
        'handle',
        'title',
        'body_html',
        'sort_order',
        'template_suffix',
        'published_scope',
        'admin_graphql_api_id',
        'src',
        'updated_at',
        'published_at'
    ];
}
