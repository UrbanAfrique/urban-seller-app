<?php

use App\Enum\TableEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable(TableEnum::ORDER_ITEMS)) {
            return true;
        }
        Schema::create(TableEnum::ORDER_ITEMS, function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->nullable();
            $table->foreignId('order_id')->nullable();
            $table->text('title')->nullable();
            $table->text('item_id')->nullable();
            $table->text('product_id')->nullable();
            $table->text('variant_id')->nullable();
            $table->text('name')->nullable();
            $table->string('quantity')->nullable();
            $table->text('sku')->nullable();
            $table->text('vendor')->nullable();
            $table->string('fulfillment_service')->nullable();
            $table->string('requires_shipping')->nullable();
            $table->string('taxable')->nullable();
            $table->string('grams')->nullable();
            $table->string('price')->nullable();
            $table->string('total_discount')->nullable();
            $table->string('fulfillment_status')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists(TableEnum::ORDER_ITEMS);
    }
}
