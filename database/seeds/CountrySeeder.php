<?php

use App\Enum\TableEnum;
use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    public function run()
    {
        DB::table(TableEnum::COUNTRIES)->truncate();
        Country::create([
            'name' => 'United States',
            'code' => 'US'
        ]);
    }
}
