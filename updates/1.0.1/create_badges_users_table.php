<?php namespace SunLab\Gamification\Updates;

use Illuminate\Database\Schema\Blueprint;
use Winter\Storm\Support\Facades\Schema;
use Winter\Storm\Database\Updates\Migration;

class CreateBadgesUsersTable extends Migration
{
    public function up()
    {
        Schema::create('sunlab_gamification_badges_users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->timestamps();
            $table->integer('user_id')->unsigned();
            $table->integer('badge_id')->unsigned();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sunlab_gamification_badges_users');
    }
}
