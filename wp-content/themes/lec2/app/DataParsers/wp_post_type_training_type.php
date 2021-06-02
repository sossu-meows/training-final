<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-08
 * Time: 16:06
 */

namespace App\DataParsers;

use App\Services\Helper;

/**
 * Data for page
 *
 * Class wp_post_type_job
 * @package App\Components\PostTypes\DataParsers
 */
class wp_post_type_training_type extends wp_post_type_default {
    public function execute(){
    	$this->id = $this->data->ID;
        parent::setCustomData();
        $returnData = array_merge((array) $this->data, $this->customData);
        $returnData['thumbnail']    = get_the_post_thumbnail_url($this->id);
        $returnData['format'] = $returnData['format']->post_title;
        return $returnData;
    }
}
