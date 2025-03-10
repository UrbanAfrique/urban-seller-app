<?php

use App\Enum\TableEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebHooksTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable(TableEnum::WEBHOOKS)) {
            return true;
        }
        Schema::create(TableEnum::WEBHOOKS, function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->nullable();
            $table->foreignId('vendor_id')->nullable();
            $table->text('web_hook_id')->nullable();
            $table->string('name')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists(TableEnum::WEBHOOKS);
    }
}
