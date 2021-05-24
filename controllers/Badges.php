<?php namespace SunLab\Gamification\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use SunLab\Gamification\Models\Badge;
use System\Classes\SettingsManager;

class Badges extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';

    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('October.System', 'system', 'settings');
        SettingsManager::setContext('SunLab.Gamification', 'settings');
    }

    // Rebuild the CollectionTree
    public function formAfterSave($model)
    {
        $badgeOfSameMeasure =
            Badge::query()->where('measure_name', $model->measure_name)
                          ->orderBy('amount_needed')
                          ->get();

        $badgeOfSameMeasure->each(function ($item, $key) use ($badgeOfSameMeasure) {
            if ($key === 0) {
                $item->parent_id = null;
            } else {
                $item->parent_id = $badgeOfSameMeasure[$key-1]->id;
            }

            $item->save();
        });
    }
}
