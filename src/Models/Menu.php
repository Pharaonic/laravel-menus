<?php

namespace Pharaonic\Laravel\Menus\Models;

use Illuminate\Database\Eloquent\Model;
use Pharaonic\Laravel\Translatable\Translatable;

/**
 * @property integer $id
 * @property string $section
 * @property string $url
 * @property integer $sort
 * @property integer $visible
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property MenuTranslation $translations
 *
 * @author Moamen Eltouny (Raggi) <raggi@raggitech.com>
 */
class Menu extends Model
{
    use Translatable;

    /**
     * Fields List
     *
     * @var array
     */
    protected $fillable = ['section', 'url', 'sort', 'visible'];

    /**
     * Translatable attributes names.
     *
     * @var array
     */
    protected $translatableAttributes = ['title'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'data'      => 'array',
        'sort'      => 'integer',
        'visible'   => 'boolean',
    ];

    /**
     * Get section'items.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $section
     * @param  string|null  $locale
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSection($query, string $section, string $locale = null)
    {
        return $query->translated($locale)->where('section', $section)->where('visible', true)->orderBy('sort', 'ASC');
    }

    /**
     * Create a localized menu.
     *
     * @param string $section
     * @param string $title
     * @param string $url
     * @param integer $sort
     * @param boolean $visible
     * @param string $locale
     * @return Menu
     */
    public static function set(string $section, string $title, string $url, int $sort = 0, bool $visible = true, string $locale = null)
    {
        $menu           = new self;
        $menu->section  = $section;
        $menu->url      = $url;
        $menu->sort     = $sort;
        $menu->visible  = $visible;
        $menu->save();

        $menu->translateOrNew($locale ?? app()->getLocale())->title = $title;
        $menu->save();

        return $menu;
    }
}
