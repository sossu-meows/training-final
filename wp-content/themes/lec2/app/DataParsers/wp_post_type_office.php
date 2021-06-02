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
 * data for partner
 *
 * Class DefaultPostType
 * @package App\Components\PostTypes\DataParsers
 */
class wp_post_type_office extends wp_post_type_default
{

    /**
     * Override parent method
     */
    public function setCustomData()
    {
        $this->customData = Helper::getFields($this->id);
    }

}