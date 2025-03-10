<?php

namespace App\Models;

use App\Enum\TableEnum;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = TableEnum::STATES;
    protected $fillable = [
        'name',
        'code'
    ];
}
