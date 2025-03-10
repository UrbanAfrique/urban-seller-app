<?php

use App\Enum\TableEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{

    public function up()
    {
        if (Schema::hasTable(TableEnum::COUNTRIES)) {
            return true;
        }
        Schema::create(TableEnum::COUNTRIES, function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->unique();
            $table->string('code')->nullable()->unique();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists(TableEnum::COUNTRIES);
    }
};
