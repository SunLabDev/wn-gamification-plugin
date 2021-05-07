<?php namespace SunLab\Gamification\Components;

use Cms\Classes\ComponentBase;
use Winter\User\Facades\Auth;
use Winter\User\Models\User;

class UserBadges extends BadgesList
{
    public function onRun()
    {
        $this->addCss('components/assets/style.css');

        if ($this->property('logged-user')) {
            $user = Auth::user();
        } else {
            $userId = $this->property('user-id');
            $user = User::find($userId);
        }

        $badges = $user->badges();

        if (!$this->property('tree-displayed')) {
            $badges->orderBy('measure_name')
                   ->orderBy('amount_needed');
        }

        $this->badges = $badges->get();

        if ($this->property('tree-displayed')) {
            $this->badges = $this->badges->toNested();
        }
    }

    public function componentDetails()
    {
        return [
            'name'        => 'sunlab.gamification::lang.components.user_badge',
            'description' => 'sunlab.gamification::lang.components.user_badge_description'
        ];
    }

    public function defineProperties()
    {
        return array_merge(
            [
                'user-id' => [
                    'title'       => 'sunlab.gamification::lang.components.user_id',
                    'description' => 'sunlab.gamification::lang.components.user_id_description',
                    'default'     => '{{ :id }}',
                    'type'        => 'string',
                ],
                'logged-user' => [
                    'title'       => 'sunlab.gamification::lang.components.logged_user',
                    'description' => 'sunlab.gamification::lang.components.logged_user_description',
                    'type'        => 'checkbox',
                ],
            ],
            parent::defineProperties()
        );
    }
}
