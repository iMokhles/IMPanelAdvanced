<?php
/**
 * Created by PhpStorm.
 * User: imokhles
 * Date: 23/10/2018
 * Time: 03:44
 */

namespace App\Http\Controllers\Backpack;


use App\Models\Backpack\MenuItem;
use Backpack\CRUD\app\Http\Controllers\CrudController;

use Illuminate\Foundation\Http\FormRequest as StoreRequest;
use Illuminate\Foundation\Http\FormRequest as UpdateRequest;

class MenuItemCrudController extends CrudController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth:admin');
    }

    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel(MenuItem::class);
        $this->crud->setRoute('admin' . '/menu-item');
        $this->crud->setEntityNameStrings('menu item', 'menu items');


        $this->crud->allowAccess('reorder');
        $this->crud->enableReorder('name', 2);

        // Columns.
        $this->crud->setColumns([
            [
                'name' => 'name',
                'label' => 'Label',
            ],
            [
                'label' => 'Parent',
                'type' => 'select',
                'name' => 'parent_id',
                'entity' => 'parent',
                'attribute' => 'name',
                'model' => MenuItem::class,
            ]
        ]);

        // Fields
        $this->crud->addFields([
            [
                'name' => 'name',
                'label' => 'Label',
            ],
            [
                'label' => 'Parent',
                'type' => 'select',
                'name' => 'parent_id',
                'entity' => 'parent',
                'attribute' => 'name',
                'model' => MenuItem::class,
            ],
            [
                'name' => 'type',
                'label' => 'Type',
                'type' => 'page_or_link',
                'model' => MenuItem::class,
            ],
        ]);
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}