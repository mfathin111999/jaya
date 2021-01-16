<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeHasWorkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_has_works', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned()->index();
            $table->integer('resource_id')->unsigned()->index();
            $table->double('salary')->default(0);
            $table->string('type_worker', 30)->default('internal');
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
        Schema::dropIfExists('employee_has_works');
    }
}
