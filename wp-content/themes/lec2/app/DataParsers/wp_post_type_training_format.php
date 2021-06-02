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
class wp_post_type_training_format extends wp_post_type_default
{

    public function execute(){
    	$this->id = $this->data->ID;
        parent::setCustomData();
        $returnData = array_merge((array) $this->data, $this->customData);
        return $returnData;
    }
}


