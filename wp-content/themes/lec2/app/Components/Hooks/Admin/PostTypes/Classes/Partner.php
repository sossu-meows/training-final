<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-07-29
 * Time: 16:45
 */

namespace App\Components\Hooks\Admin\PostTypes\Classes;

use App\Components\Hooks\Admin\PostTypes\Abstracts\AbstractPostType;
use App\Components\AcfFields\Consts\PostTypes\Partner as Field;

/**
 * Class Partner - define partner post type
 *
 * @package App\Components\Hooks\Admin\PostTypes\Classes
 */


class Partner extends AbstractPostType
{
    protected  $label           = 'Partners';
    protected  $singleName      = 'Partner';
    protected  $name            = Field::_NAME;
    protected  $url             = Field::_URL;
    protected  $shortDescription = Field::_DESCRIPTION;

    protected $menuIcon = 'dashicons-buddicons-buddypress-logo';

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
            'thumbnail'         =>  __('Image','lec2_text_domain'),
            Field::_DESCRIPTION =>  __('Short Description','lec2_text_domain'),
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
            $shortDescription = '';
            if( have_rows('banner') ):
                while( have_rows('banner') ): the_row();
                    $shortDescription = get_sub_field('partners_short_description',$postID);
                endwhile;
            endif;

            if($shortDescription){
                echo "$shortDescription";
            }
        }
    }

}