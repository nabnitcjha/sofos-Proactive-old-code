<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeExtraColumnTimetableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('timetable', function (Blueprint $table) {
            //
            $table->datetime('start_time')->nullable();
            $table->datetime('end_time')->nullable();
            $table->string('start_time_am_pm')->nullable();
            $table->string('end_time_am_pm')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('timetable', function (Blueprint $table) {
            //
        });
    }
}
