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

    // Search for an eventual parent to link before save
    public function formBeforeSave($model)
    {
        $correspondingParentBadge = Badge::query()
                                         ->select('id')
                                         ->where([
                                             ['measure_name', '=', $model->measure_name],
                                             ['amount_needed', '<', $model->amount_needed]
                                         ])
                                         ->orderByDesc('amount_needed')
                                         ->first();

        if ($correspondingParentBadge) {
            $model->parent_id = $correspondingParentBadge->id;
        }
    }
}
