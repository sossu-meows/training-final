<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-07-29
 * Time: 17:00
 */

namespace App\Services\Training;

use App\Services\AbstractListingAjax;
use App\Services\Helper;

/**
 * Class ListTrainings
 * List all Training and paginate them.
 * If you want to get objects and paginate, please make your own class extend from AbstractListingObjects
 * - But we don't need paginate for training so that i  make this class extend from AbstractService
 *
 * @package App\Services\Training
 */
class ListTrainingsAjaxForSchedule extends AbstractListingAjax
{

    protected  $query = [
        'post_type'         => 'product',
        'orderby'           => 'date',
        'order'             => 'desc',
        'post_status'       => 'publish'
    ];

    public function makeFilter() {

        if ($_GET) {
            $keyword        = isset($_GET['keyword']) ? $_GET['keyword'] : null;
            $dateFrom       = isset($_GET['from']) ? $_GET['from'] : null;
            $dateTo         = isset($_GET['to']) ? $_GET['to'] : null;
            $location       = isset($_GET['location_id']) ? $_GET['location_id'] : null;
        }
        if ($_POST) {
            $keyword        = isset($_POST['keyword']) ? $_POST['keyword'] : null;
            $dateFrom       = isset($_POST['from']) ? $_POST['from'] : null;
            $dateTo         = isset($_POST['to']) ? $_POST['to'] : null;
            $location       = isset($_POST['location_id']) ? $_POST['location_id'] : null;
        }

        $dateNow    = date_create('now')->format('Y-m-d');

        if (empty($dateFrom) && empty($dateTo)) {

            global $wpdb;

            $queryNoRecord = <<<EOT
            SELECT p.id FROM wp_posts AS p LEFT JOIN wp_postmeta AS mt ON p.id = mt.post_id
            WHERE p.post_type = 'product' AND
            ( mt.meta_key LIKE 'training_types_%_execution_of_training_has_recorded_video' AND mt.meta_value = 0 )
            GROUP BY p.id
EOT;

            $queryWithRecord = <<<EOT
            SELECT p.id FROM wp_posts AS p LEFT JOIN wp_postmeta AS mt ON p.id = mt.post_id
            WHERE p.post_type = 'product' AND
            ( mt.meta_key LIKE 'training_types_%_execution_of_training_has_recorded_video' AND mt.meta_value = 1 )
            GROUP BY p.id
EOT;
            $noRecordProducts   = $wpdb->get_results( $queryNoRecord, ARRAY_A );
            $recordProducts     = $wpdb->get_results( $queryWithRecord, ARRAY_A );

            if ($noRecordProducts && $recordProducts) {
                foreach ($noRecordProducts as $index => $noRecordProduct) {
                    foreach ($recordProducts as $key => $recordProduct) {
                        if ($noRecordProduct == $recordProduct) {
                            unset($noRecordProducts[$index]);
                        }
                    }
                }
            }

            if ($noRecordProducts) {

                $dateNow 	= date_create('now')->format('Y-m-d');
                $this->query['meta_query'] = [
                    array(
                        'relation' => 'OR',
                        array(
                            'key'       => 'training_types_&&_execution_of_training_live_course_dates_&&_date',
                            'value'     => $dateNow,
                            'compare'   => '>=',
                            'type'      => 'DATE'
                        ),
                        array(
                            'key'       => 'training_types_&&_execution_of_training_has_recorded_video',
                            'value'     => 1,
                            'compare'   => '=',
                        )
                    )

                ];
            }
        }

        if (!empty($keyword)) {
            $this->query['s'] = $keyword;
        }

        if (!empty($dateFrom)) {

            $dateFrom   = date("Y-m-d", strtotime("$dateFrom"));

            if (strtotime($dateFrom) <= strtotime($dateNow)) {
                $date = $dateNow;
            } else {
                $date = $dateFrom;
            }

            $this->query['meta_query'] = array(
                array(
                    'key'       => 'training_types_&&_execution_of_training_live_course_dates_&&_date',
                    'value'     => $date,
                    'compare'   => '>=',
                    'type'      => 'DATE'
                )
            );
        }

        if (!empty($dateTo)) {

            $toDate         = date("Y-m-d", strtotime("$dateTo"));
            $fromDate       = date("Y-m-d", strtotime("$dateFrom"));

            if ($dateFrom && strtotime($fromDate) >= strtotime($dateNow) ) {
                $firstDate = $fromDate;
            } else {
                $firstDate = $dateNow;
            };

            if ($firstDate) {

                $this->query['meta_query'] = array(
                    array(
                        'key'       => 'training_types_&&_execution_of_training_live_course_dates_&&_date',
                        'value'     => array($firstDate, $toDate),
                        'compare'   => 'BETWEEN',
                        'type'      => 'date'
                    )
                );
            }
        }
    }
}