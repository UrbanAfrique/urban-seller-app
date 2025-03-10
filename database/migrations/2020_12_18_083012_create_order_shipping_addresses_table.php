<?php

use App\Enum\TableEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderShippingAddressesTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable(TableEnum::ORDER_SHIPPING_ADDRESSES)) {
            return true;
        }
        Schema::create(TableEnum::ORDER_SHIPPING_ADDRESSES, function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->nullable();
            $table->foreignId('order_id')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->text('address1')->nullable();
            $table->text('address2')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('province_code')->nullable();
            $table->string('country')->nullable();
            $table->string('country_code')->nullable();
            $table->string('zip')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists(TableEnum::ORDER_SHIPPING_ADDRESSES);
    }
}
