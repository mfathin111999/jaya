<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 7);
            $table->integer('user_id')->unsigned()->index()->nullable();
            $table->string('name', 128);
            $table->string('email', 128)->unique();
            $table->string('phone_number', 20)->nullable();
            $table->integer('province_id')->index()->unsigned()->nullable();
            $table->integer('regency_id')->index()->unsigned()->nullable();
            $table->integer('district_id')->index()->unsigned()->nullable();
            $table->integer('village_id')->index()->unsigned()->nullable();
            $table->date('date_start');
            $table->date('date_end');
            $table->time('time_start');
            $table->time('time_end');
            $table->text('note')->nullable();
            $table->string('status', 30)->default('progress');
            $table->integer('payment_id')->unsigned()->index();
            $table->rememberToken();
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
        Schema::dropIfExists('reservations');
    }
}
