<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableWeekDays extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('week_days', function (Blueprint $table) {
            $table->id();
            $table->integer('week_day_number')->nullable();
            $table->string('title_ru')->nullable();
            $table->string('title_kz')->nullable();
            $table->string('title_en')->nullable();
            $table->string('lesson_begin_time')->nullable();
            $table->integer('lesson_duration')->nullable();
            $table->integer('break_duration')->nullable();
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
        Schema::dropIfExists('week_days');
    }
}
