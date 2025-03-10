<?php

use App\Enum\ApprovedStatusEnum;
use App\Enum\TableEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable(TableEnum::PRODUCTS)) {
            return true;
        }
        Schema::create(TableEnum::PRODUCTS, function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->nullable();
            $table->foreignId('vendor_id')->nullable();
            $table->text('product_id')->nullable();
            $table->text('title')->nullable();
            $table->text('handle')->nullable();
            $table->longText('tags')->nullable();
            $table->string('product_category')->nullable();
            $table->string('product_vendor')->nullable();
            $table->longText('product_type')->nullable();
            $table->json('collections')->nullable();
            $table->longText('body_html')->nullable();
            $table->string('template_suffix')->nullable();
            $table->string('published_scope')->nullable();
            $table->string('status')->nullable();
            $table->longText('image')->nullable();
            $table->json('images')->nullable();
            $table->json('shopify_images')->nullable();
            $table->string('option1')->nullable();
            $table->string('option2')->nullable();
            $table->string('option3')->nullable();
            $table->json('options')->nullable();
            $table->longText('site_url')->nullable();
            $table->enum('approved', ApprovedStatusEnum::getValues())->default(ApprovedStatusEnum::PENDING);
            $table->longText('reject_reason')->nullable();

            $table->boolean('wholesale')->nullable();
            $table->integer('min_qty')->nullable();
            $table->text('discount_type')->nullable();
            $table->float('discount_value', 11, 2)->nullable();
            $table->longText('metafields')->nullable();
            $table->string('discount_id')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(TableEnum::PRODUCTS);
    }
};
