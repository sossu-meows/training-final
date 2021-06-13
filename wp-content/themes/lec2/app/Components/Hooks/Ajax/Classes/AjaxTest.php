<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-14
 * Time: 16:33
 */

namespace App\Components\Hooks\Ajax\Classes;

use App\Components\Hooks\Ajax\AbstractAjax;
use App\Services\LiveCourseDates\ListLiveCourseDates;
use App\Services\Product\ListProductsByTime;
use DateTime;

/**
 * Class GetProducts - Get more products
 *
 * @package App\Components\Hooks\Ajax\Classes
 */
class AjaxTest extends AbstractAjax
{
    //training_types_0_execution_of_training_live_course_dates_1_date
    protected $functions = ['ajax_test' =>  'getProducts'];

    /**
     * Get Products
     */
    public function getProducts()
    {
        //$time = date("Y-m-d h:i:s");
        $time = new DateTime();
        $get_now = new DateTime();

        $get_time = new ListLiveCourseDates();
        $data = $get_time->execute();
        debug($data, true);
    }
}
