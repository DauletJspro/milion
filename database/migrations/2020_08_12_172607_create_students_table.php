<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('parent_full_name');
            $table->string('parent_phone');
            $table->string('name');
            $table->string('last_name');
            $table->string('middle_name');
            $table->text('address');
            $table->text('school');
            $table->string('phone');
            $table->integer('course_price');
            $table->integer('advisor_id');
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
        Schema::dropIfExists('students');

    }
}
