<?php

namespace App\Models;

use App\Enum\TableEnum;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = TableEnum::CITIES;
}
