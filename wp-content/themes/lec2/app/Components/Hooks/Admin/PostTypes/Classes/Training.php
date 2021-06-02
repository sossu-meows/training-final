<?php


namespace App\Components\Hooks\Admin\PostTypes\Classes;


use App\Components\AcfFields\Consts\PostTypes\Training as Field;
use App\Components\Hooks\Admin\PostTypes\Abstracts\AbstractPostType;

class Training extends AbstractPostType
{

    protected  $label           = 'Trainings';
    protected  $singleName      = 'Training';
    protected  $name            = Field::_NAME;
    protected  $time            = Field::_TIME;
    protected  $format          = Field::_FORMAT;
    protected  $cost            = Field::_COST;
    protected  $menuIcon        = 'dashicons-book';

    public function selfHook()
    {
        $this->registerTax('training-category', 'Training Categories', 'Training', true);
    }

    public function adminColumns($defaults)
    {
        // TODO: Implement adminColumns() method.
        return [
            'cb'                =>  $defaults['cb'],
            'title'             =>  __('Name','lec2_text_domain'),
            'thumbnail'         =>  __('Thumbnail','lec2_text_domain'),
            'category'          =>  __('Categories','lec2_text_domain'),
        ];
    }

    public function adminColumnsContent($columnName, $postID)
    {
        // TODO: Implement adminColumnsContent() method.
        if($columnName == 'thumbnail'){
            $url = get_the_post_thumbnail_url($postID);
            if($url){
                echo "<img src='{$url}' class='table-thumbnail' >";
            }
        }
        if($columnName == 'category'){
            $categories = get_the_terms($postID, 'training-category');
            $termNames = [];
            if($categories){
                foreach($categories as $term) {
                    $termNames[] = $term->name;
                }
            }
            echo implode(', ', $termNames);
        }
    }
}