<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEngagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('engagements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 7);
            $table->date('date');
            $table->time('time');
            $table->date('date_work', 50)->nullable();
            $table->string('name', 128)->nullable();
            $table->string('email', 128)->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->text('address')->nullable();
            $table->char('village_id', 30)->index()->nullable();
            $table->char('district_id', 30)->index()->nullable();
            $table->char('regency_id', 30)->index()->nullable();
            $table->char('province_id', 30)->index()->nullable();
            $table->text('description')->nullable();
            $table->string('status', 30)->default('pending');
            $table->string('locked', 30)->default('offer');
            $table->char('vendor_is', 5)->nullable()->default(0);
            $table->char('customer_is', 5)->nullable()->default(0);
            $table->integer('vendor_id')->unsigned()->index();
            $table->integer('mandor_id')->unsigned()->index();
            $table->integer('partner_id')->unsigned()->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('engagements');
    }
}
