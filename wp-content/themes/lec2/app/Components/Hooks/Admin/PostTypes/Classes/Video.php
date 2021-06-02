<?php


namespace App\Components\Hooks\Admin\PostTypes\Classes;


use App\Components\AcfFields\Consts\PostTypes\Video as Field;
use App\Components\Hooks\Admin\PostTypes\Abstracts\AbstractPostType;

class Video extends AbstractPostType
{

    protected  $label           = 'Videos';
    protected  $singleName      = 'Video';
    protected  $name            = Field::_NAME;
    protected  $menuIcon        = 'dashicons-video-alt3';

    public function selfHook()
    {
    }

    public function adminColumns($defaults)
    {
        // TODO: Implement adminColumns() method.
        return [
            'cb'                =>  $defaults['cb'],
            'title'             =>  __('Name','lec2_text_domain'),
            'thumbnail'         =>  __('Thumbnail','lec2_text_domain'),
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
    }
}