<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 128);
            $table->string('address');
            $table->integer('village_id')->unsigned()->index();            
            $table->integer('district_id')->unsigned()->index();            
            $table->integer('regency_id')->unsigned()->index();            
            $table->integer('province_id')->unsigned()->index();
            $table->string('ktp', 30);
            $table->string('picture', 50);
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
        Schema::dropIfExists('employees');
    }
}
