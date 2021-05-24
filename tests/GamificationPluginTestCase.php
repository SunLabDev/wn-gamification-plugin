<?php namespace SunLab\Gamification\Tests;

use SunLab\Measures\Models\ListenedEvent;
use PluginTestCase;
use Winter\User\Facades\Auth;

abstract class GamificationPluginTestCase extends PluginTestCase
{
    protected $user;
    protected $listenedEvent;

    public function setUp(): void
    {
        parent::setUp();

        // Create a base listened event for the tests
        $this->listenedEvent = new ListenedEvent;
        $this->listenedEvent->event_name = 'model.afterUpdate';
        $this->listenedEvent->measure_name = 'user_updated';
        $this->listenedEvent->model_to_watch = \Winter\User\Models\User::class;
        $this->listenedEvent->save();

        $this->getPluginObject('SunLab.Measures')->boot();

        $this->getPluginObject()->boot();

        // Create a base use model for the tests
        $this->user = Auth::register([
            'username' => 'username',
            'email' => 'user@user.com',
            'password' => 'abcd1234',
            'password_confirmation' => 'abcd1234'
        ]);
    }
}
