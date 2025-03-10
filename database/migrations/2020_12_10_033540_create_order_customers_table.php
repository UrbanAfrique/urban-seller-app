<?php

use App\Enum\TableEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderCustomersTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable(TableEnum::ORDER_CUSTOMERS)) {
            return true;
        }
        Schema::create(TableEnum::ORDER_CUSTOMERS, function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->nullable();
            $table->foreignId('order_id')->nullable();
            $table->text('customer_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('tags')->nullable();
            $table->string('orders_count')->nullable();
            $table->string('state')->nullable();
            $table->string('total_spent')->nullable();
            $table->string('company')->nullable();
            $table->text('address1')->nullable();
            $table->text('address2')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('country')->nullable();
            $table->string('zip')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(TableEnum::ORDER_CUSTOMERS);
    }
}
