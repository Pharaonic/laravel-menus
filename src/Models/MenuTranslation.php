<?php

namespace Pharaonic\Laravel\Menus\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $menu_id
 * @property string $locale
 * @property string $title
 *
 * @author Moamen Eltouny (Raggi) <raggi@raggitech.com>
 */
class MenuTranslation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['locale', 'menu_id', 'title'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
