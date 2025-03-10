<?php

use App\Enum\TableEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable(TableEnum::ORDERS)) {
            return true;
        }
        Schema::create(TableEnum::ORDERS, function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->nullable();
            $table->foreignId('vendor_id')->nullable();
            $table->text('order_id')->nullable();
            $table->string('order_number')->nullable();
            $table->string('subtotal_price')->nullable();
            $table->string('total_price')->nullable();
            $table->string('total_price_usd')->nullable();
            $table->string('total_weight')->nullable();
            $table->string('total_tax')->nullable();
            $table->json('tax_lines')->nullable();
            $table->string('currency')->nullable();
            $table->string('financial_status')->nullable();
            $table->string('fulfillment_status')->nullable();
            $table->string('total_discounts')->nullable();
            $table->json('discount_applications')->nullable();
            $table->json('discount_codes')->nullable();
            $table->string('total_line_items_price')->nullable();
            $table->longText('note')->nullable();
            $table->json('note_attributes')->nullable();
            $table->json('client_details')->nullable();
            $table->json('payment_details')->nullable();
            $table->json('payment_gateway_names')->nullable();
            $table->text('processing_method')->nullable();
            $table->text('checkout_id')->nullable();
            $table->text('source_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('reference')->nullable();
            $table->string('confirmed')->nullable();
            $table->longText('cancel_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(TableEnum::ORDERS);
    }
}
