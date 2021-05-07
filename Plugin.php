<?php namespace SunLab\Gamification;

use Backend;
use Event;
use System\Classes\PluginBase;
use Winter\User\Models\User;
use SunLab\Gamification\Models\Badge;
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

    public function pluginDetails()
    {
        return [
            'name' => 'sunlab.gamification::lang.details.name',
            'description' => 'sunlab.gamification::lang.details.description',
            'author' => 'SunLab',
            'icon' => 'icon-trophy'
        ];
    }

    public function boot()
    {
        User::extend(function ($user) {
            $user->belongsToMany['badges'] = [Badge::class, 'table' => 'sunlab_gamification_badges_users'];

            if (!$user->isClassExtendedWith('SunLab.Measures.Behaviors.Measurable')) {
                $user->extendClassWith('SunLab.Measures.Behaviors.Measurable');
            }
        });


        Event::listen('sunlab.measures.incrementMeasure', function ($model, $measure) {
            if (!$model instanceof User) {
                return;
            }

            $correspondingBadges =
                Badge::where([['measure_name', $measure->name], ['amount_needed', '<=', $measure->amount]])
                    ->whereDoesntHave('users', function ($query) use ($model) {
                        $query->where('user_id', $model->id);
                    })->get();

            if (!blank($correspondingBadges)) {
                // Because multiple attach doesn't fill created events
                // We need to manually set the timestamps
                $now = now();
                $attachedBadges = array_combine(
                    $correspondingBadges->pluck('id')->toArray(),
                    array_fill(0, count($correspondingBadges), ['updated_at' => $now, 'created_at' => $now])
                );

                $model->badges()->attach($attachedBadges);
            }
        });
    }

    public function registerComponents()
    {
        return [
            \SunLab\Gamification\Components\BadgesList::class => 'badgesList',
            \SunLab\Gamification\Components\UserBadges::class => 'userBadges',
        ];
    }

    public function registerSettings()
    {
        return [
            'location' => [
                'label' => 'sunlab.gamification::lang.settings.name',
                'description' => 'sunlab.gamification::lang.settings.description',
                'category' => SettingsManager::CATEGORY_USERS,
                'icon' => 'icon-trophy',
                'url' => Backend::url('sunlab/gamification/badges'),
                'order' => 500,
                'permissions' => ['sunlab.gamification.manage_badges'],
                'keywords' => 'geography place placement'
            ]
        ];
    }

    public function registerPermissions()
    {
        return [
            'sunlab.gamification.manage_badges' => [
                'tab' => 'sunlab.gamification::lang.settings.name',
                'label' => 'sunlab.gamification::lang.permissions.label'
            ],
        ];
    }
}
