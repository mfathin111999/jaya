<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tax_id')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number', 30)->nullable();
            $table->string('ktp', 30);
            $table->string('owner')->nullable();
            $table->string('bank_name', 30)->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('vendor', 20)->nullable();
            $table->string('customer', 20)->nullable();
            $table->string('search_key')->nullable();
            $table->char('province_id', 30)->nullable();
            $table->char('regency_id', 30)->nullable();
            $table->char('district_id', 30)->nullable();
            $table->char('village_id', 30)->nullable();
            $table->string('address')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendors');
    }
}
