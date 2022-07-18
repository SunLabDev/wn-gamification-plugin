<?php namespace SunLab\Gamification\Updates;

use Illuminate\Database\Schema\Blueprint;
use Winter\Storm\Support\Facades\Schema;
use Winter\Storm\Database\Updates\Migration;

class CreateBadgesTable extends Migration
{
    public function up()
    {
        Schema::create('sunlab_gamification_badges', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('measure_name');
            $table->integer('amount_needed')->unsigned();
            $table->integer('parent_id')->unsigned()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sunlab_gamification_badges');
    }
}
