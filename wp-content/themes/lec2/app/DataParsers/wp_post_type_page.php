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
class wp_post_type_page extends wp_post_type_default
{
    /**
     * Override parent method
     */
    public function setCustomData()
    {
        $this->customData =  Helper::getFields($this->id);
    }

}


