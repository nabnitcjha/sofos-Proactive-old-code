<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AgainCreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('teachers', function (Blueprint $table) {
            //
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('gender');
            $table->datetime('DOB')->nullable();
            $table->string('email')->unique();
            $table->string('religion');
            $table->string('teacher_image')->nullable();
            $table->string('address')->nullable();
            $table->string('address2')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('phone')->nullable();
            $table->string('alternate_phone')->nullable();
            $table->string('highest_degree')->nullable();
            $table->string('university')->nullable();
            $table->datetime('year_passed')->nullable();
            $table->string('cgpa')->nullable();
            $table->string('other_degree')->nullable();
            $table->string('other_university')->nullable();
            $table->datetime('other_year_passed')->nullable();
            $table->string('other_cgpa')->nullable();
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
        Schema::dropIfExists('teachers');
    }
}
