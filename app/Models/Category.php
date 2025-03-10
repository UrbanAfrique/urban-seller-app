<?php

namespace App\Models;

use App\Enum\TableEnum;
use Illuminate\Database\Eloquent\Model;
class Category extends Model
{

    protected $table = TableEnum::CATEGORIES;
    protected $fillable = [
        'name'
    ];
}

