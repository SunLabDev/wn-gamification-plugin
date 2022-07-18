<?php namespace SunLab\Gamification\Models;

use Model;
use System\Models\File;
use Winter\User\Models\User;

/**
 * Badge Model
 */
class Badge extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    use \Winter\Storm\Database\Traits\SimpleTree;

    public $table = 'sunlab_gamification_badges';

    protected $guarded = ['*'];

    public $rules = [
        'name' => 'required'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public $belongsToMany = [
        'users' => [User::class, 'table' => 'sunlab_gamification_badges_users']
    ];

    public $attachOne = [
        'image' => File::class
    ];
}
