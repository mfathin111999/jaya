<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportEngagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reservation_id')->unsigned()->index();
            $table->string('parent_id')->nullable();
            $table->string('name', 150);
            $table->string('volume', 150)->nullable();
            $table->string('unit', 20)->nullable();
            $table->string('time', 10)->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->date('date_pay')->nullable();
            $table->text('description')->nullable();
            $table->string('price_clean', 50)->default(0);
            $table->string('price_dirt', 50)->default(0);
            $table->string('status')->nullable()->default('offer');
            $table->string('termin')->nullable();
            $table->string('is_payed')->nullable();
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
        Schema::dropIfExists('reports');
    }
}
