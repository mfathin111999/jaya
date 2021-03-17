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
            $table->integer('service_id')->unsigned()->index();            
            $table->integer('user_id')->unsigned()->index()->nullable();            
            $table->string('name', 128)->nullable();
            $table->string('email', 128)->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->integer('village_id')->unsigned()->index()->nullable();
            $table->integer('district_id')->unsigned()->index()->nullable();
            $table->integer('regency_id')->unsigned()->index()->nullable();
            $table->integer('province_id')->unsigned()->index()->nullable();
            $table->text('description');
            $table->string('status', 30)->default('pending');
            $table->string('termin', 30)->nullable();
            $table->integer('vendor_id')->unsigned()->index();
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
