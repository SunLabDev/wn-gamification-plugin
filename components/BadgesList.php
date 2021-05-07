<?php namespace SunLab\Gamification\Components;

use Cms\Classes\ComponentBase;
use SunLab\Gamification\Models\Badge;

class BadgesList extends ComponentBase
{
    public $badges = [];

    public function onRun()
    {
        $this->addCss('components/assets/style.css');

        $badges = Badge::query()->withCount('users');

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
            'name'        => 'sunlab.gamification::lang.components.badge_list',
            'description' => 'sunlab.gamification::lang.components.badge_list_description'
        ];
    }

    public function defineProperties()
    {
        return [
            'tree-displayed' => [
                'title'       => 'sunlab.gamification::lang.components.tree_displayed',
                'description' => 'sunlab.gamification::lang.components.tree_displayed_description',
                'type'        => 'checkbox',
            ],
        ];
    }
}
