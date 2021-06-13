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
use Carbon\Carbon;
use DateTime;

/**
 * Class ListTrainings
 * List all Training and paginate them.
 * If you want to get objects and paginate, please make your own class extend from AbstractListingObjects
 * - But we don't need paginate for training so that i  make this class extend from AbstractService
 *
 * @package App\Services\Product
 */
class ListProductsByTime extends AbstractService
{


    public function getTimeZone()
    { ?>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script type="text/javascript">
            function createCookie(e, t, o) {
                var i;
                if (o) {
                    var date = new Date;
                    date.setTime(date.getTime() + 24 * o * 60 * 60 * 1e3), i = "; expires=" + date.toGMTString()
                } else
                    i = "";
                url = window.location.href, document.cookie = escape(e) + "=" + escape(t) + i + "; path=" + url
            }
            $(document).ready(function() {
                createCookie("time_zone_client", Intl.DateTimeFormat().resolvedOptions().timeZone, "1")
            });
        </script>
<?php
        return $_COOKIE["time_zone_client"];
    }

    public function execute()
    {



        $time_zone_client = $this->getTimeZone();


        if (isset($_GET['from_date'])) {


            $get_from_date = date_create($_GET['from_date'], timezone_open($time_zone_client));
            date_timezone_set($get_from_date, timezone_open(wp_timezone_string()));
            $from_date = $get_from_date->format("Y-m-d h:i:s");
            if ($_GET['to_date'] != '') {

                $get_to_date = date_create($_GET['to_date'], timezone_open($time_zone_client));
                date_timezone_set($get_to_date, timezone_open(wp_timezone_string()));
                $to_date = $get_to_date->format("Y-m-d h:i:s");
            } else {

                $to_date = date("Y-m-d h:i:s");
            }
        } else {
            $from_date = date("Y-m-d h:i:s");
        }

        global $wpdb;
        $query = <<<EOT
            SELECT SQL_CALC_FOUND_ROWS  p.ID, p.post_title, p.post_content FROM wp_posts AS p  INNER JOIN wp_postmeta AS mt1 ON ( p.ID = mt1.post_id )  INNER JOIN wp_postmeta AS mt2 ON ( mt1.post_id = mt2.post_id ) WHERE 1=1  AND ( 
            ( mt1.meta_key LIKE 'training_types_%_execution_of_training_live_course_dates_%_date' AND mt1.meta_value BETWEEN '{$from_date}' AND '{$to_date}' ) 
            AND 
            ( mt2.meta_key LIKE 'training_types_%_execution_of_training_has_live_course' AND mt2.meta_value = '1' )
               AND
              (SUBSTRING_INDEX(mt1.meta_key, '_execution_of_training_live_course_dates_',1) = REPLACE(mt2.meta_key, '_execution_of_training_has_live_course', ''))
             ) 
             AND p.post_type = 'product' AND (p.post_status = 'publish' OR p.post_status = 'acf-disabled' OR p.post_status = 'future' OR p.post_status = 'draft' OR p.post_status = 'pending' OR p.post_status = 'private') GROUP BY p.ID ORDER BY p.post_date DESC LIMIT 0, 10

        EOT;



        $data = $wpdb->get_results($query);
        foreach ($data as $key => $value) {
            $returnData['posts'][$key] = $value;
        }


        wp_reset_postdata();
        return $returnData;
    }
}
