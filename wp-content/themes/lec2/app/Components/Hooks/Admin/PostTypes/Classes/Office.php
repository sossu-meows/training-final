<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-07-29
 * Time: 16:45
 */

namespace App\Components\Hooks\Admin\PostTypes\Classes;

use App\Components\Hooks\Admin\PostTypes\Abstracts\AbstractPostType;
use App\Components\AcfFields\Consts\PostTypes\Office as Field;

/**
 * Class Office - define office post type
 *
 * @package App\Components\Hooks\Admin\PostTypes\Classes
 */


class Office extends AbstractPostType
{
    protected  $label           = 'Offices';
    protected  $singleName      = 'Office';
    protected  $name            = Field::_NAME;
    protected  $menuIcon = 'dashicons-admin-multisite';

    /**
     * Override's parrent method
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
            'cb'                    =>  $defaults['cb'],
            Field::_BANNER_IMAGE    =>  __('Image','lec2_text_domain'),
            'title'                 =>  __('Name','lec2_text_domain'),
            Field::_ADDRESS         =>  __('Address','lec2_text_domain'),
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

        if($columnName == Field::_BANNER_IMAGE){
            $url = get_field( Field::_BANNER_IMAGE);
            if($url){
                echo "<img src='{$url}' class='table-thumbnail' >";
            }
        }
        elseif($columnName == Field::_ADDRESS){
            $address =  get_field(Field::_ADDRESS);
            if(is_array($address)){
                echo isset($address['address'])?$address['address']:'';
            }elseif (is_string($address)){
                echo $address;
            }

        }
    }

}