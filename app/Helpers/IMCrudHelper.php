<?php
/**
 * Created by PhpStorm.
 * User: imokhles
 * Date: 23/10/2018
 * Time: 04:33
 */

namespace App\Helpers;


class IMCrudHelper
{

    public static function getSettingsImageColumn($value) {
        return '<a href="'.url(config('backpack.settings.image_prefix').$value).'"><img class="img-circle" width="70px" height="70px" src="'.url('/uploads/'.$value).'" alt="'.$value.'"></a>';
    }
    public static function getSettingsPasswordColumn() {
        return '<a class="btn btn-default"><i class="fa fa-key"></i></a>';
    }
    public static function getSettingsIconColumn($value) {
        return '<a class="btn btn-default"><i class="fa '.$value.'"></i></a>';
    }
    public static function getSettingsEmailColumn($value) {
        return '<a href="mailto:'.$value.'" target="_top">'.$value.'</a>';
    }
    public static function getSettingsUrlColumn($value) {
        return '<a href="'.$value.'">'.$value.'</a>';
    }
    public static function getSettingsCheckboxColumn($value) {
        if ($value == 1) {
            // if true return success label with YES string
            $html = '<span class="label label-success">YES</span>';
        } else {
            // if false return danger label with NO string
            $html = '<span class="label label-danger">NO</span>';
        }
        return $html;
    }
    public static function getSaveActionButtonName($actionValue = 'save_and_back')
    {
        switch ($actionValue) {
            case 'save_and_edit':
                return trans('backpack::crud.save_action_save_and_edit');
                break;
            case 'save_and_new':
                return trans('backpack::crud.save_action_save_and_new');
                break;
            case 'save_and_back':
            default:
                return trans('backpack::crud.save_action_save_and_back');
                break;
        }
    }
}