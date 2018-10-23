<?php
/**
 * Created by PhpStorm.
 * User: imokhles
 * Date: 23/10/2018
 * Time: 04:19
 */

namespace App\Http\Controllers\Backpack;


use App\Helpers\IMCrudHelper;
use App\Models\Backpack\Setting;
use Backpack\CRUD\app\Http\Controllers\CrudController;
// VALIDATION
use Backpack\Settings\app\Http\Requests\SettingRequest as StoreRequest;
use Backpack\Settings\app\Http\Requests\SettingRequest as UpdateRequest;
class SettingCrudController extends CrudController
{
    public function setup()
    {
        parent::setup();
        $this->crud->setModel(Setting::class);
        $this->crud->setEntityNameStrings(trans('backpack::settings.setting_singular'), trans('backpack::settings.setting_plural'));
        $this->crud->setRoute(backpack_url('setting'));
        $this->crud->addClause('where', 'active', 1);
        $this->crud->setColumns([
            [
                'name'  => 'name',
                'label' => trans('backpack::settings.name'),
            ],
            [
                'name'  => 'key',
                'label' => trans('backpack::settings.key'),
            ],
            [
                'name'          => 'value',
                'label'         => trans('backpack::settings.value'),
                'type'          => 'model_function',
                'function_name' => 'getValueFunction',
                'limit' => 500
            ],
            [
                'name'  => 'description',
                'label' => trans('backpack::settings.description'),
            ],
        ]);
        $this->crud->addFields([
            [
                'name'       => 'name',
                'label'      => trans('backpack::settings.name'),
                'type'       => 'text',
            ],
            [
                'name'  => 'key',
                'label' => trans('backpack::settings.key'),
                'type'  => 'text',
            ],
            [
                'name'  => 'description',
                'label' => trans('backpack::settings.description'),
                'type'  => 'text',
            ],
            [ // select_from_array
                'name'    => 'field',
                'label'   => trans('backpack::settings.select_field'),
                'type'    => 'select2_from_array',
                'options' => [
                    'text'          => 'Text',
                    'email'         => 'Email',
                    'checkbox'      => 'Checkbox',
                    'number'        => 'Number',
                    'url'           => 'URL',
                    'image'         => 'Image',
                    'password'      => 'Password',
                    'icon_picker'   => 'Icon Picker',
                ],
                'allows_null' => false,
            ],
            [
                'name'  => 'active',
                'label' => trans('backpack::settings.active'),
                'type'  => 'checkbox',
            ],
        ]);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return parent::index();
    }

    /**
     * @param UpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        return parent::storeCrud();
    }

    /**
     * @param int $id
     * @return \Backpack\CRUD\app\Http\Controllers\Operations\Response|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Backpack\CRUD\Exception\AccessDeniedException
     */
    public function edit($id)
    {
        $this->crud->hasAccessOrFail('update');
        $this->data['entry'] = $this->crud->getEntry($id);
        $this->crud->addField((array) $this->getFieldJsonValue($id, $this->isImageField($id))); // <---- this is where it's different
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = [
            'active' => [
                'value' => 'save_and_edit',
                'label' => IMCrudHelper::getSaveActionButtonName('save_and_edit')
            ],
            'options' => [
                'save_and_back' => IMCrudHelper::getSaveActionButtonName('save_and_back'),
                'save_and_new' => IMCrudHelper::getSaveActionButtonName('save_and_new')
            ]
        ];
        $this->data['fields'] = $this->crud->getUpdateFields($id);
        $this->data['title'] = trans('backpack::crud.edit').' '.$this->crud->entity_name;
        $this->data['id'] = $id;
        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view($this->crud->getEditView(), $this->data);
    }

    /**
     * @return \Backpack\CRUD\app\Http\Controllers\Operations\Response|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Backpack\CRUD\Exception\AccessDeniedException
     */
    public function create()
    {
        $this->crud->hasAccessOrFail('create');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = [
            'active' => [
                'value' => 'save_and_edit',
                'label' => IMCrudHelper::getSaveActionButtonName('save_and_edit')
            ],
            'options' => [
                'save_and_back' => IMCrudHelper::getSaveActionButtonName('save_and_back'),
                'save_and_new' => IMCrudHelper::getSaveActionButtonName('save_and_new')
            ]
        ];
        $this->data['fields'] = $this->crud->getCreateFields();
        $this->data['title'] = trans('backpack::crud.add').' '.$this->crud->entity_name;

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view($this->crud->getCreateView(), $this->data);
    }

    /**
     * @param UpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request)
    {
        return parent::updateCrud();
    }

    /**
     * get the correct field json value to add the correct field to edit form.
     *
     * @param int  $id
     * @param bool $isImage
     *
     * @return array
     */
    protected function getFieldJsonValue($id, $isImage = true)
    {
        $fieldValue = $this->crud->getEntry($id)->field;
        $fieldJson = [];
        if ($isImage == false) {
            $fieldJson['name'] = 'value';
            $fieldJson['label'] = 'Value';
            $fieldJson['type'] = $fieldValue;
            return $fieldJson;
        } else {
            $fieldJson['name'] = 'value';
            $fieldJson['label'] = 'Value';
            $fieldJson['type'] = $fieldValue;
            $fieldJson['upload'] = config('backpack.settings.image_upload_enabled');
            $fieldJson['crop'] = config('backpack.settings.image_crop_enabled');
            $fieldJson['aspect_ratio'] = config('backpack.settings.image_aspect_ratio');
            $fieldJson['prefix'] = config('backpack.settings.image_prefix');
            return $fieldJson;
        }
    }

    /**
     * get the correct field type.
     *
     * @param int $id
     *
     * @return string
     */
    protected function getFieldType($id)
    {
        return $this->crud->getEntry($id)->field;
    }
    /**
     * get the correct field type.
     *
     * @param int $id
     *
     * @return bool
     */
    protected function isImageField($id)
    {
        return $this->getFieldType($id) == 'image' ? true : false;
    }
}