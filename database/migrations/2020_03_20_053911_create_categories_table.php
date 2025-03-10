<?php

use App\Enum\TableEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable(TableEnum::CATEGORIES)) {
            return true;
        }
        Schema::create(TableEnum::CATEGORIES, function (Blueprint $table) {
            $table->id();
            $table->longText('name')->unique()->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists(TableEnum::CATEGORIES);
    }
}
