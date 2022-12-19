<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToStudentSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_sessions', function (Blueprint $table) {
            //
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->string('time_am_pm')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_sessions', function (Blueprint $table) {
            //
        });
    }
}
