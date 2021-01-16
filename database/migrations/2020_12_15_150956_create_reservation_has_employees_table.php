<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationHasEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_has_employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 128);
            $table->integer('reservation_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index()->nullable();
            $table->integer('type')->unsigned()->index();
            $table->string('type_role')->default('employee');
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
        Schema::dropIfExists('reservation_has_employees');
    }
}
