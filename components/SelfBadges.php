<?php namespace SunLab\Badges\Components;

use Cms\Classes\ComponentBase;
use Winter\User\Facades\Auth;

class SelfBadges extends ComponentBase
{
    public $badges = null;

    public function init()
    {
        $this->badges = Auth::getUser()->badges;
    }

    public function componentDetails()
    {
        return [
            'name'        => 'UserBadges Component',
            'description' => 'No description provided yet...'
        ];
    }
}
