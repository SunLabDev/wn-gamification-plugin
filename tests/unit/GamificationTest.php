<?php namespace SunLab\Gamification\Tests\Unit\Facades;

use SunLab\Gamification\Models\Badge;
use SunLab\Gamification\Tests\GamificationPluginTestCase;

class GamificationTest extends GamificationPluginTestCase
{
    public function testBadgeIsAssignedWhenGoalIsReached()
    {
        $this->createUndecidedBadge();

        // Update the model 5 times
        for ($i = 1; $i <= 5; $i++) {
            $this->user->email = "other-email${i}@test.com";
            $this->user->save();

            // On the 4th updates, asserts it doesn't have the badge yet
            if ($i === 4) {
                $this->assertEmpty($this->user->badges->toArray());
            }
        }

        $this->user->load('badges');
        $this->assertNotEmpty($this->user->badges->toArray());
        $this->assertEquals('Undecided', $this->user->badges()->first()->name);
    }

    public function testBadgesAreAssignedWithMeasuresBackwardCompatibility()
    {
        // Update the model more times than needed to get the badge
        for ($i = 1; $i <= 6; $i++) {
            $this->user->email = "other-email${i}@test.com";
            $this->user->save();
        }

        // Badge is not created yet, it's forcefully empty
        $this->assertEmpty($this->user->badges->toArray());

        // Create the badge and update one more time, the badge should be attached
        $this->createUndecidedBadge();

        $this->user->email = "other-email7@test.com";
        $this->user->save();

        $this->user->load('badges');
        $this->assertNotEmpty($this->user->badges->toArray());
        $this->assertEquals('Undecided', $this->user->badges()->first()->name);
    }

    public function testBadgesCanBeAttachedMultipleAtOnce()
    {
        // Update the model 9 times than needed to get the badge
        for ($i = 1; $i <= 9; $i++) {
            $this->user->email = "other-email${i}@test.com";
            $this->user->save();
        }

        // Badge is not created yet, it's forcefully empty
        $this->assertEmpty($this->user->badges->toArray());

        // Create two badges and update one more time, the badges should be attached
        $this->createUndecidedBadge();

        $badge = new Badge;
        $badge->name = 'Really Undecided';
        $badge->measure_name = $this->listenedEvent->measure_name;
        $badge->amount_needed = 10;
        $badge->save();

        $this->user->email = "other-email10@test.com";
        $this->user->save();

        $this->user->load('badges');
        $this->assertNotEmpty($this->user->badges->toArray());
        $this->assertEquals(2, $this->user->badges()->count());
    }

    public function testCanAttachAndDetachBadgeDirectly()
    {
        $this->createUndecidedBadge();

        $this->user->attachBadge('Undecided');
        $this->user->load('badges');
        $this->assertEquals('Undecided', $this->user->badges()->first()->name);

        $this->user->detachBadge('Undecided');
        $this->assertEquals(0, $this->user->badges()->count());
    }

    // Create a badge which should be assigned when a User model is updated 5 times
    protected function createUndecidedBadge()
    {
        $badge = new Badge;
        $badge->name = 'Undecided';
        $badge->measure_name = $this->listenedEvent->measure_name;
        $badge->amount_needed = 5;
        $badge->save();
    }
}
