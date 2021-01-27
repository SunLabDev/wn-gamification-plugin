<?php namespace SunLab\Badges\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateBadgesTable extends Migration
{
    public function up()
    {
        Schema::create('sunlab_badges_badges', function (Blueprint $table) {
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
        Schema::dropIfExists('sunlab_badges_badges');
    }
}
