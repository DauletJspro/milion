<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTitleColorToWeekDays extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('week_days', function (Blueprint $table) {
            $table->string('color_type')->nullable()->after('break_duration');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('week_days', function (Blueprint $table) {
            $table->dropColumn('color_type');
        });
    }
}
