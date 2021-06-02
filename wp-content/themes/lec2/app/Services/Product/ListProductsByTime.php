<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-07-29
 * Time: 17:00
 */

namespace App\Services\Product;

use App\Services\AbstractService;
use WP_Query;

/**
 * Class ListTrainings
 * List all Training and paginate them.
 * If you want to get objects and paginate, please make your own class extend from AbstractListingObjects
 * - But we don't need paginate for training so that i  make this class extend from AbstractService
 *
 * @package App\Services\Training
 */
class ListProductsByTime extends AbstractService
{



    public function execute()
    {

        if (isset($_GET['from_date'])) {


            $from_date = $_GET['from_date'];
            if ($_GET['to_date'] != '') {
                $to_date = $_GET['to_date'];
            } else {
                $to_date = date("Y-m-d h:i:s");
            }
        } else {
            $from_date = date("Y-m-d h:i:s");
        }
        $args = array(
            'numberposts'    => -1,
            'post_type'        => 'product',
            'meta_query'    => array(
                'relation'        => 'AND',
                array(
                    'key'        => 'training_types_&&_execution_of_training_live_course_dates_&&_date',
                    'compare'    => 'BETWEEN',
                    'value'        => array($from_date, $to_date),
                ),
                array(
                    'key'        => 'training_types_&&_execution_of_training_has_live_course',
                    'compare'    => '=',
                    'value'        => '1',
                )
            )
        );
        $data = new WP_Query($args);
        $tam = $data->posts;
        $returnData['post'] = $tam;


        return $returnData;
    }
}
