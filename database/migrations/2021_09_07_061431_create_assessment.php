<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment', function (Blueprint $table) {
            //
            $table->id();
            $table->integer('grade_id')->unsigned();
            $table->integer('assessment_type_id')->unsigned();
            $table->integer('subject_id')->unsigned();
            $table->string('submitBy');
            $table->integer('assessment_file')->unsigned();
            $table->string('remark');
            $table->integer('teacher_id')->unsigned();
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
        Schema::dropIfExists('assessment');
    }
}
