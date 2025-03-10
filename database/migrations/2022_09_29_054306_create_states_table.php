<?php

use App\Enum\TableEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatesTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable(TableEnum::STATES)) {
            return true;
        }
        Schema::create(TableEnum::STATES, function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->nullable();
            $table->string('name')->nullable()->unique();
            $table->string('code')->nullable()->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(TableEnum::STATES);
    }
};
