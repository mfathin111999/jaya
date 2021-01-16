<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username', 100)->unique();
            $table->string('email', 128)->unique();
            $table->string('password', 255);
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->integer('province_id')->index()->unsigned()->nullable();
            $table->integer('regency_id')->index()->unsigned()->nullable();
            $table->integer('district_id')->index()->unsigned()->nullable();
            $table->integer('village_id')->index()->unsigned()->nullable();
            $table->string('role', 30);
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
        Schema::dropIfExists('users');
    }
}
