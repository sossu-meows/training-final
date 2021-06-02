<?php


namespace App\Components\Hooks\Admin\PostTypes\Classes;


use App\Components\Hooks\Admin\PostTypes\Abstracts\AbstractPostType;
use App\Components\AcfFields\Consts\PostTypes\Testimonial as Field;

/**
 * Class Testimonial - define testimonial post type
 *
 * @package App\Components\Hooks\Admin\PostTypes\Classes
 */

class Testimonial extends AbstractPostType
{
    protected  $label           = 'Testimonials';
    protected  $singleName      = 'Testimonial';
    protected  $name            = Field::_NAME;
    protected  $position        = Field::_POSITION;
    protected  $menuIcon        = 'dashicons-cover-image';

    /**
     * Override's parent method
     *
     * @return void
     */
    public function selfHook()
    {

    }

    /**
     * Admin columns
     *
     * @return array|mixed
     */
    public function  adminColumns($defaults){

        return [
            'cb'                =>  $defaults['cb'],
            'title'             =>  __('Name','lec2_text_domain'),
            'thumbnail'         =>  __('Thumbnail','lec2_text_domain'),
            Field::_POSITION    =>  __('Position','lec2_text_domain'),
            Field::_DESCRIPTION =>  __('Description','lec2_text_domain'),
        ];
    }

    /**
     * Customize for content of admin column
     *
     * @param $columnName
     * @param $postID
     * @return mixed|void
     */
    public function adminColumnsContent($columnName, $postID)
    {
        if($columnName == 'thumbnail'){
            $url = get_the_post_thumbnail_url($postID);
            if($url){
                echo "<img src='{$url}' class='table-thumbnail' >";
            }
        }
        if($columnName == Field::_DESCRIPTION){
            $description = get_field('testimonial_client_description',$postID);
            if($description){
                echo "$description";
            }
        }
        if($columnName == Field::_POSITION){
            $position = get_field('testimonial_client_position',$postID);
            if($position){
                echo "$position";
            }
        }
    }
}