<?php

use App\Enum\TableEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellersTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable(TableEnum::SELLERS)) {
            return true;
        }
        Schema::create(TableEnum::SELLERS, function (Blueprint $table) {
            $table->id();
            $table->text('store_id')->nullable();
            $table->string('name')->nullable();
            $table->string('owner')->nullable();
            $table->text('domain')->nullable();
            $table->text('primary_location_id')->nullable();
            $table->text('primary_locale')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('tags')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('country')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->longText('address1')->nullable();
            $table->longText('address2')->nullable();
            $table->string('zip')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('currency')->nullable();
            $table->string('money_format')->nullable();
            $table->string('hmac')->nullable();
            $table->string('token')->nullable();
            $table->boolean('term_of_use')->default(false);
            $table->boolean('privacy_policy')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(TableEnum::SELLERS);
    }
}
