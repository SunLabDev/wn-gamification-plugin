<?php namespace SunLab\Badges\Components;

use Cms\Classes\ComponentBase;
use Winter\User\Models\User;

class UserBadges extends ComponentBase
{
    public $badges = [];

    public function onRun()
    {
        $userId = $this->property('user-id');
        $user = User::find($userId);
        $this->badges = $user->badges;
    }

    public function componentDetails()
    {
        return [
            'name'        => 'UserBadges Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'user-id' => [
                'title'       => 'sunlab.badges::lang.components.user_id',
                'description' => 'sunlab.badges::lang.components.user_id_description',
                'default'     => '{{ :id }}',
                'type'        => 'string',
            ],
        ];
    }
}
