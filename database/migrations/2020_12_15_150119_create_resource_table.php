<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 128);
            $table->string('type', 30);
            $table->string('type_service', 50)->nullable();
            $table->double('price')->default(0)->unsigned()->nullable();
            $table->integer('width')->default(0)->unsigned()->nullable();
            $table->integer('height')->default(0)->unsigned()->nullable();
            $table->integer('length')->default(0)->unsigned()->nullable();
            $table->integer('weight')->default(0)->unsigned()->nullable();
            $table->string('unit', 30)->nullable();
            $table->integer('quantity')->unsigned()->nullable();
            $table->string('color')->nullable();
            $table->string('material')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('resources');
    }
}
