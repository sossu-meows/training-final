<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-14
 * Time: 16:33
 */

namespace App\Components\Hooks\Ajax\Classes;

use App\Components\Hooks\Ajax\AbstractAjax;
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
        //debug($get_now->format("Y-m-d"), true);
        //$coupon_start_date = $get_now->date;
        $add = date_add($get_now, date_interval_create_from_date_string('3 months'));
        $add = strtotime($add->format("Y-m-d"));
        debug($add, true);
        //$str_to_time = strtotime($time);
        // debug(time(), true);
        // debug($str_to_time, true);
    }
}
