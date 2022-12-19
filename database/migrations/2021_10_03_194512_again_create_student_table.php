<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AgainCreateStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('students', function (Blueprint $table) {
            //
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('gender')->nullable();
            $table->datetime('DOB')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->unique();

            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();

            $table->string('religion')->nullable();
            $table->string('student_image')->nullable();
            $table->string('registration')->nullable();
            $table->string('roll')->nullable();
            $table->string('section')->nullable();
            $table->string('country')->nullable();
            $table->string('grade_id')->nullable();
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
        //
        Schema::dropIfExists('students');
    }
}
