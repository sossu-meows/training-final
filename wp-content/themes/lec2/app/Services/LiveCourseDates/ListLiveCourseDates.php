<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-07-29
 * Time: 17:00
 */

namespace App\Services\LiveCourseDates;

use App\Services\AbstractService;


/**
 * Class ListTrainings
 * List all Training and paginate them.
 * If you want to get objects and paginate, please make your own class extend from AbstractListingObjects
 * - But we don't need paginate for training so that i  make this class extend from AbstractService
 *
 * @package App\Services\LiveCourseDates
 */
class ListLiveCourseDates extends AbstractService
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

        global $wpdb;
        $query = <<<EOT
        SELECT *  FROM `wp_postmeta` WHERE `meta_key` LIKE 'training_types_%_execution_of_training_live_course_dates_%_date'
        EOT;
        $data = $wpdb->get_results($query);
        foreach ($data as $key => $value) {
            $date =  date_create($value->meta_value, timezone_open(wp_timezone_string()));
            $convert = date_timezone_set($date, timezone_open($time_zone_client));

            $returnData['live_course_dates'][$key] = $convert->format("d/m/Y h:i-A");
        }



        return $returnData;
    }
}
