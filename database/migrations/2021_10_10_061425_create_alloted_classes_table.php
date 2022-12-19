<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllotedClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alloted_classes', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id')->nullable();
            $table->integer('teacher_id')->nullable();
            $table->integer('slot_id')->nullable();
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
        Schema::dropIfExists('alloted_classes');
    }
}
