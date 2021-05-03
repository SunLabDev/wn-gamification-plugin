<?php namespace SunLab\Badges\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateBadgesUsersTable extends Migration
{
    public function up()
    {
        Schema::create('sunlab_badges_badges_users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->timestamps();
            $table->integer('user_id')->unsigned();
            $table->integer('badge_id')->unsigned();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sunlab_badges_badges');
    }
}
