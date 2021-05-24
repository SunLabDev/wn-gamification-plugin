<?php namespace Winter\User\Tests\Unit\Facades;

use Backend\Models\User;
use SunLab\Measures\Models\ListenedEvent;
use SunLab\Measures\Tests\MeasuresPluginTestCase;

class MeasuresTest extends MeasuresPluginTestCase
{
    public function testIncrementingMeasuresFromAnEvent()
    {
        User::extend(function ($model) {
            $model->bindEvent('model.afterUpdate', function () use ($model) {
                $model->incrementMeasure('user_updated');
            });
        });

        $this->createUser();

        $this->user->email = 'other-email@test.com';
        $this->user->save();

        $this->assertEquals(1, $this->user->getAmountOf('user_updated'));
    }

    public function testIncrementingMeasuresFromAListenedEvent()
    {
        $listenedEvent = new ListenedEvent;
        $listenedEvent->event_name = 'model.afterUpdate';
        $listenedEvent->measure_name = 'user_updated';
        $listenedEvent->model_to_watch = User::class;
        $listenedEvent->save();

        $this->getPluginObject()->boot();

        $this->createUser();
        $this->user->email = 'other-email@test.com';
        $this->user->save();

        $this->assertEquals(1, $this->user->getAmountOf('user_updated'));
    }
}
