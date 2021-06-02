<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-08
 * Time: 16:07
 */

namespace App\DataParsers;

use App\Services\Helper;

/**
 * if the post type can't find it parser, it will call this class
 *
 * Class DefaultPostType
 * @package App\Components\PostTypes\DataParsers
 */
class wp_post_type_post extends wp_post_type_default
{

    /**
     * Execute and return
     *
     * @return array
     */
    public function execute(){
        $this->id = $this->data->ID;
        $this->setCustomData();
        $returnData                 = (array) $this->data;
        $returnData['post_excerpt'] = get_the_excerpt($this->id);
        $returnData['custom_data']  = $this->customData;
        $returnData['url']          = get_the_permalink($this->id);
        $returnData['thumbnail']    = get_the_post_thumbnail_url($this->id);

        if ($returnData['custom_data']['video']) {
            $returnData['custom_data']['video'] = apply_filters("modify_post_type", $returnData['custom_data']['video']);
        }
        return $returnData;
    }

}