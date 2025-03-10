<?php

use App\Enum\ProductStatusEnum;
use App\Enum\TableEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable(TableEnum::SETTINGS)) {
            return true;
        }
        Schema::create(TableEnum::SETTINGS, function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->nullable();
            $table->boolean('vendor_auto_approval')->default(false);
            $table->boolean('product_auto_approval')->default(false);
            $table->string('product_status')->nullable(ProductStatusEnum::DRAFT);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(TableEnum::SETTINGS);
    }
}

;
