<?php

use App\Enum\TableEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomCollectionsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable(TableEnum::CUSTOM_COLLECTIONS)) {
            return true;
        }
        Schema::create(TableEnum::CUSTOM_COLLECTIONS, function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->nullable();
            $table->text('collection_id')->nullable();
            $table->text('handle')->nullable();
            $table->longText('title')->nullable();
            $table->longText('body_html')->nullable();
            $table->string('sort_order')->nullable();
            $table->string('template_suffix')->nullable();
            $table->string('published_scope')->nullable();
            $table->string('admin_graphql_api_id')->nullable();
            $table->text('src')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists(TableEnum::CUSTOM_COLLECTIONS);
    }
}
