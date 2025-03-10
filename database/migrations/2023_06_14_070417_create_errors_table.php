<?php

use App\Enum\TableEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErrorsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable(TableEnum::ERRORS)) {
            return true;
        }
        Schema::create(TableEnum::ERRORS, function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->nullable();
            $table->foreignId('vendor_id')->nullable();
            $table->string('type')->nullable();
            $table->longText('message')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists(TableEnum::ERRORS);
    }
}
