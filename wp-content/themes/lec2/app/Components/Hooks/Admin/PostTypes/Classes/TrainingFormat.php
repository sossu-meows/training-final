<?php


namespace App\Components\Hooks\Admin\PostTypes\Classes;


use App\Components\AcfFields\Consts\PostTypes\TrainingFormat as Field;
use App\Components\Hooks\Admin\PostTypes\Abstracts\AbstractPostType;

class TrainingFormat extends AbstractPostType
{

    protected  $label           = 'Training Formats';
    protected  $singleName      = 'Training Format';
    protected  $name            = Field::_NAME;
    protected  $menuIcon        = 'dashicons-book';
    protected  $support         = array('title','custom-fields');

    public function selfHook() {}

    public function adminColumns($defaults)
    {
        // TODO: Implement adminColumns() method.
        return [
            'cb'                =>  $defaults['cb'],
            'title'             =>  __('Name','lec2_text_domain')
        ];
    }

    public function adminColumnsContent($columnName, $postID)
    {
        // TODO: Implement adminColumnsContent() method.
    }
}