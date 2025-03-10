<?php
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(CountrySeeder::class);
        $this->call(StateSeeder::class);
    }
}
