<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherNotesToAddNewColumnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_notes', function (Blueprint $table) {
            //
            $table->id();
            $table->string('notes')->nullable();
            $table->integer('timetable_id')->unsigned();
            $table->integer('teacher_id')->unsigned();
            $table->string('access_type');
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
        Schema::table('teacher_notes', function (Blueprint $table) {
            //
        });
    }
}
