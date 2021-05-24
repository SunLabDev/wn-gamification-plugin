## Gamification
This plugin allows you to reward your members when some actions are made.
To increment the statistics, this plugin is using [SunLab.Measures](https://github.com/sunlabdev/measures)

### How to use
From the backend, create all the needed badges.
A badge need at least, a name,
a measure name corresponding to one previously set with [SunLab.Measures](https://github.com/sunlabdev/measures),
and the amount needed to win the badge.

### Components
This plugin comes with two components:
#### BadgesList
Displays all the badge that can be rewarded,
and the number of members of member who already won it.

#### UserBadges
Displays only the badges that a specific member won.
The member could be the one actually logged in, or set by an url parameter.

### Tree view
The `Badge` model implement `SimpleTree`.
If you want to display the badges as a tree,
use the components' property `tree-displayed` to optimize the database search.

*The default query will load the badges ordered by their measure name and amount needed.*

### Measures reminder
[SunLab.Measures](https://github.com/sunlabdev/measures) is internally used by the plugin to increment
some measures when some events are emitted.
You can configure the most basic events from the backend using the generic event listener of `Measures`,
but for complexes cases, you'll need to manually create the listener from a `Plugin.php` file.

A use case for this could be to give a badge rewarding immediately after the registration,
because plugins' events are not supported by `Measures` as of today, we need to create it manually:
```php
\Winter\User\Models\User::extend(function ($user) {
    $user->bindEvent('model.afterCreate', function () use ($user) {
        $user->incrementMeasure('registered');
    });
});
```
