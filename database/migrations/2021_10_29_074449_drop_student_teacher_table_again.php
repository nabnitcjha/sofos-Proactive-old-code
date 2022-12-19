<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropStudentTeacherTableAgain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
        });
        Schema::table('students', function (Blueprint $table) {
            $table->string('middle_name')->nullable()->change();
            $table->string('last_name')->nullable()->change();
            $table->string('email')->nullable()->change();
        });
        Schema::table('teachers', function (Blueprint $table) {
            $table->string('middle_name')->nullable()->change();
            $table->string('last_name')->nullable()->change();
            $table->string('gender')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('religion')->nullable()->change();
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
    }
}
