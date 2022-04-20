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
 * @property integer $parent_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Menu $children
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
    protected $fillable = ['section', 'url', 'sort', 'visible', 'parent_id'];

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
     * Get section items.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $section
     * @param  string|null  $locale
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSection($query, string $section, string $locale = null)
    {
        return $query->translated($locale)->with([
            'children' => function ($q) {
                return $q->visible();
            },
            'children.translations'
        ])->where([
            'section'   => $section,
            'parent_id' => null
        ])->visible()->orderBy('sort', 'ASC');
    }

    /**
     * Get visible items.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisible($query)
    {
        return $query->where('visible', true);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id');
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
    public static function set(string $section, mixed $title, string $url, int $parent = null, int $sort = 0, bool $visible = true)
    {
        $menu = new self;
        $data = [
            'section' => $section,
            'url'       => $url,
            'parent_id' => $parent,
            'sort'      => $sort,
            'visible'   => $visible
        ];

        $localKey = $menu->translationsKey ?? 'locale';

        if (is_array($title))
            $data[$localKey] = $title;
        else
            $data[$localKey][app()->getLocale()]['title'] = $title;

        $menu->fill($data)->save();
        return $menu;
    }
}
