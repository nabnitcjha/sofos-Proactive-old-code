<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TypeChangeAssessmentDeadlineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('assessment','deadline')){
            Schema::table('assessment', function (Blueprint $table) {
                $table->dropColumn('deadline');
                $table->datetime('deadline')->nullable();
            });
        }else{
            Schema::table('assessment', function (Blueprint $table) {
                $table->datetime('deadline')->nullable();
            });
        }
        
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
