<?php

use App\Enum\TableEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable(TableEnum::CUSTOMERS)) {
            return true;
        }
        Schema::create(TableEnum::CUSTOMERS, function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->nullable();
            $table->text('customer_id')->nullable();
            $table->string('email')->nullable();
            $table->text('verified_email')->nullable();
            $table->string('accepts_marketing')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('orders_count')->nullable();
            $table->string('state')->nullable();
            $table->string('total_spent')->nullable();
            $table->text('last_order_id')->nullable();
            $table->text('last_order_name')->nullable();
            $table->text('multipass_identifier')->nullable();
            $table->text('tax_exempt')->nullable();
            $table->longText('tags')->nullable();
            $table->string('currency')->nullable();
            $table->string('phone')->nullable();
            $table->text('accepts_marketing_updated_at')->nullable();
            $table->text('marketing_opt_in_level')->nullable();
            $table->text('admin_graphql_api_id')->nullable();
            $table->longText('default_address')->nullable();
            $table->longText('addresses')->nullable();
            $table->longText('note')->nullable();
            $table->longText('tax_exemptions')->nullable();
            $table->longText('email_marketing_consent')->nullable();
            $table->longText('sms_marketing_consent')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(TableEnum::CUSTOMERS);
    }
}
