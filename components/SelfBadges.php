<?php namespace SunLab\Badges\Components;

use Cms\Classes\ComponentBase;

class SelfBadges extends ComponentBase
{
    public function init()
    {

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
            'max' => [
                'description'       => 'The most amount of todo items allowed',
                'title'             => 'Max items',
                'default'           => true,
                'type'              => 'boolean',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'The Max Items value is required and should be integer.'
            ]
        ];
    }
}
