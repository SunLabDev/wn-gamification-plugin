<?php

use Winter\User\Models\User;

Route::get('/test-plugin', function() {
  // Tu get le premier User
  $user = User::first();

  // Tu incrément une mesure bidon
  $measure = $user->incrementMeasure('talk');
  $measure = $user->incrementMeasure('like');


  // Tu affiche la mesure et les badges du user
  dd($user->badges);
});
