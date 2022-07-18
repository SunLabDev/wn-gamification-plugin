<?php namespace SunLab\Gamification\Updates;

use Illuminate\Database\Schema\Blueprint;
use Winter\Storm\Support\Facades\Schema;
use Winter\Storm\Database\Updates\Migration;

class SetBadgeMeasureNullable extends Migration
{
    public function up()
    {
        Schema::table('sunlab_gamification_badges', function (Blueprint $table) {
            $table->string('measure_name')->nullable()->change();
            $table->integer('amount_needed')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('sunlab_gamification_badges', function (Blueprint $table) {
            $table->string('measure_name')->nullable(false)->change();
            $table->integer('amount_needed')->nullable(false)->change();
        });
    }
}
