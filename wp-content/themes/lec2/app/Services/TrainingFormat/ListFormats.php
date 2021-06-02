<?php

    namespace App\Services\TrainingFormat;
    use App\Services\AbstractService;

    /**
     * Class ListFormats
     * List all Formats and paginate them.
     * If you want to get objects and paginate, please make your own class extend from AbstractListingObjects
     * - But we don't need paginate for training so that i  make this class extend from AbstractService
     *
     * @package App\Services\TrainingFormat
     */

    class ListFormats extends AbstractService
    {
        protected $query = [
            'post_type'         => 'training_format',
            'posts_per_page'    => 10,
            'orderby'           => 'post_title',
            'order'             => 'asc',
            'post_status'       => 'publish',
        ];

        /**
         * Override parent method
         *
         * @return array
         */
        public function execute()
        {
            global $wp_query;
            // The Query
            $objs = query_posts($this->query);
            $returnData = [];

            if (is_array($objs) && count($objs) > 0) {
                foreach ($objs as $obj) {
                    $returnData[] = $this->parseData($obj);
                }
            }
            wp_reset_postdata();

            return $returnData;
        }

        /*
     * Get list training Type for filtering in header
     * */
        public function executeFilter()
        {
            $data               = array();
            $trainingFormats    = get_posts($this->query);

            foreach( $trainingFormats as $trainingFormat ) {
                $data[] = array(
                    "label" => $trainingFormat->post_title,
                    "value" => $trainingFormat->ID
                );
            }

            return $data;
        }
    }