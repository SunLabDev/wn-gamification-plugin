<?php namespace SunLab\Badges\Components;

use Cms\Classes\ComponentBase;
use SunLab\Badges\Models\Badge;

class BadgesList extends ComponentBase
{
    public $badges = null;

    public function init()
    {
        $this->badges = Badge::all();
    }

    public function componentDetails()
    {
        return [
            'name'        => 'sunlab.badges::lang.components.badge_list',
            'description' => 'sunlab.badges::lang.components.badge_list_description'
        ];
    }
}
