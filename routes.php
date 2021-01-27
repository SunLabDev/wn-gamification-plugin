<?php 

use RainLab\User\Models\User;

Route::get('/test-plugin', function() {
  // Tu get le premier User
  $user = User::first();
  
  // Tu incrément une mesure bidon
  $measure = $user->incrementMeasure('badge_1_mesure');
  

  // Tu affiche la mesure et les badges du user
  dump($measure); // Peut être tu devra accéder à ->amount pour afficher le nb, pas testé
  dd($user->badges);
});