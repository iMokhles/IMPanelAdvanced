<?php
/**
 * Created by PhpStorm.
 * User: imokhles
 * Date: 23/10/2018
 * Time: 03:42
 */

namespace App\Models\Backpack;


use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use CrudTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'menu_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'type', 'link', 'page_id', 'parent_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo('Backpack\MenuCRUD\app\Models\MenuItem', 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany('Backpack\MenuCRUD\app\Models\MenuItem', 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function page()
    {
        return $this->belongsTo('Backpack\PageManager\app\Models\Page', 'page_id');
    }

    /**
     * Get all menu items, in a hierarchical collection.
     * Only supports 2 levels of indentation.
     * @return mixed
     */
    public static function getTree()
    {
        $menu = self::orderBy('lft')->get();
        if ($menu->count()) {
            foreach ($menu as $k => $menu_item) {
                $menu_item->children = collect([]);
                foreach ($menu as $i => $menu_subitem) {
                    if ($menu_subitem->parent_id == $menu_item->id) {
                        $menu_item->children->push($menu_subitem);
                        // remove the subitem for the first level
                        $menu = $menu->reject(function ($item) use ($menu_subitem) {
                            return $item->id == $menu_subitem->id;
                        });
                    }
                }
            }
        }
        return $menu;
    }

    /**
     * @return \Illuminate\Contracts\Routing\UrlGenerator|mixed|string
     */
    public function url()
    {
        switch ($this->type) {
            case 'external_link':
                return $this->link;
                break;
            case 'internal_link':
                return is_null($this->link) ? '#' : url($this->link);
                break;
            default: //page_link
                if ($this->page) {
                    return url($this->page->slug);
                }
                break;
        }
    }
}