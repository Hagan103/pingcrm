<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->index();
            $table->integer('body_id')->nullable()->index();
//            $table->integer('daily_calorie_intake');
            $table->string('name');
            $table->integer('weeks');
            $table->integer('mon_calorie_intake');
            $table->integer('tue_calorie_intake');
            $table->integer('wed_calorie_intake');
            $table->integer('thu_calorie_intake');
            $table->integer('fri_calorie_intake');
            $table->integer('sat_calorie_intake');
            $table->integer('sun_calorie_intake');
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
        Schema::dropIfExists('schedules');
    }
}
