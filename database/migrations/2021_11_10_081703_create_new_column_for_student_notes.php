<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewColumnForStudentNotes extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_notes', function (Blueprint $table) {
            //
            $table->id();
            $table->string('notes')->nullable();
            $table->integer('timetable_id')->unsigned();
            $table->integer('student_id')->unsigned();
            $table->string('access_type')->nullable();
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
        Schema::table('student_notes', function (Blueprint $table) {
            //
        });
    }
}
