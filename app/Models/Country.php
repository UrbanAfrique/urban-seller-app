<?php

namespace App\Models;

use App\Enum\TableEnum;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = TableEnum::COUNTRIES;
    protected $fillable = [
        'code', 'name'
    ];
}

