<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentRelatedTable extends Migration
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
             $table->string('assessment_type')->nullable();
             $table->integer('assessment_file')->unsigned();
             $table->datetime('deadline')->nullable();
             $table->string('time_am_pm')->nullable();
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
