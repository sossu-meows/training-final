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
class wp_post_type_default
{

    /**
     * @var \WP_Post
     */
    protected $data = null;

    protected $id = null;

    protected $customData = [];

    /**
     * @return null
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param null $data
     * @return wp_post_type_default
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Set custom data for this object, such as: custom field, custom status, taxonomy ...
     */
    public function setCustomData(){
        $this->customData = Helper::getFields($this->id);
    }

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
        //$returnData['post_content'] = apply_filters('the_content',get_the_content($this->id));
        return $returnData;
    }

}