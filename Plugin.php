<?php namespace SunLab\Badges;

use Backend;
use Event;
use System\Classes\PluginBase;
use Winter\User\Models\User;
use SunLab\Badges\Models\Badge;
use System\Classes\SettingsManager;

/**
 * Badges Plugin Information File
 */
class Plugin extends PluginBase
{
    public $require = [
        'Winter.User',
        'SunLab.Measures'
    ];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Badges',
            'description' => 'No description provided yet...',
            'author'      => 'SunLab',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot() {

        User::extend(function($user) {
            $user->belongsToMany['badges'] = [Badge::class, 'table' => 'sunlab_badges_badges_users'];

            if (!$user->isClassExtendedWith('SunLab.Measures.Behaviors.Measurable')) {
                $user->extendClassWith('SunLab.Measures.Behaviors.Measurable');
            }
        });


        Event::listen('sunlab.measures.incrementMeasure', function($model, $measure) {
            if (!$model instanceof User) {
                return;
            }

            $correspondingBadges =
                Badge::where([['measure_name', $measure->name], ['amount_needed', '<=',  $measure->amount]])
                    ->whereDoesntHave('users', function ($query) use ($model) {
                        $query->where('user_id', $model->id);
                    })->get();

            if (blank($correspondingBadges)) {
                return;
            }
            $model->badges()->attach($correspondingBadges->pluck('id'));
        });
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'SunLab\Badges\Components\MyComponent' => 'myComponent',
        ];
    }

    public function registerSettings()
    {
        return [
            'location' => [
                'label'       => 'Badges',
                'description' => 'sunlab.badges::lang.settings.description',
                'category'    => SettingsManager::CATEGORY_USERS,
                'icon'        => 'icon-space-shuttle',
                'url'         => Backend::url('sunlab/badges/badges'),
                'order'       => 500,
                'keywords'    => 'geography place placement'
            ]
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'sunlab.badges.some_permission' => [
                'tab' => 'Badges',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'badges' => [
                'label'       => 'Badges',
                'url'         => Backend::url('sunlab/badges/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['sunlab.badges.*'],
                'order'       => 500,
            ],
        ];
    }
}
