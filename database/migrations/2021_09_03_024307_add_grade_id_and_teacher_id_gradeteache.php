<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGradeIdAndTeacherIdGradeteache extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gradeteacher', function (Blueprint $table) {
            //
            $table->id();
            $table->integer('teacher_id')->nullable();
            $table->integer('grade_id')->nullable();
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
        Schema::table('gradeteacher', function (Blueprint $table) {
            //
        });
    }
}
