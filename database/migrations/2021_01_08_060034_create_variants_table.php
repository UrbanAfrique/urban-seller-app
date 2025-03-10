<?php

use App\Enum\TableEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariantsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable(TableEnum::VARIANTS)) {
            return true;
        }
        Schema::create(TableEnum::VARIANTS, function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable();
            $table->text('variant_id')->nullable();
            $table->text('title')->nullable();
            $table->text('sku')->nullable();
            $table->text('price')->nullable();
            $table->text('compare_at_price')->nullable();
            $table->text('position')->nullable();
            $table->text('inventory_policy')->nullable();
            $table->text('fulfillment_service')->nullable();
            $table->text('inventory_management')->nullable();
            $table->text('option1')->nullable();
            $table->text('option2')->nullable();
            $table->text('option3')->nullable();
            $table->text('taxable')->nullable();
            $table->text('barcode')->nullable();
            $table->text('weight')->nullable();
            $table->text('weight_unit')->nullable();
            $table->text('inventory_item_id')->nullable();
            $table->text('inventory_quantity')->nullable();
            $table->text('old_inventory_quantity')->nullable();
            $table->text('requires_shipping')->nullable();
            $table->longText('image')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists(TableEnum::VARIANTS);
    }
};
