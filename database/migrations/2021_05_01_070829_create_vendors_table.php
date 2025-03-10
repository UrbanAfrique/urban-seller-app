<?php

use App\Enum\ApprovedStatusEnum;
use App\Enum\TableEnum;
use App\Enum\VendorTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable(TableEnum::VENDORS)) {
            return true;
        }
        Schema::create(TableEnum::VENDORS, function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->nullable();
            $table->foreignId('customer_id')->nullable();
            $table->string('name')->nullable();
            $table->string('owner')->nullable();
            $table->text('domain')->nullable();
            $table->longText('tags')->nullable();
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
            $table->string('company')->nullable();
            $table->enum('vendor_type', VendorTypeEnum::getValues())->default(VendorTypeEnum::SHOP);
            $table->enum('approved', ApprovedStatusEnum::getValues())->default(ApprovedStatusEnum::PENDING);
            $table->longText('reject_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(TableEnum::VENDORS);
    }
};
