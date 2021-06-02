<?php
    /**
     * Created by PhpStorm.
     * User: admin
     * Date: 2019-07-29
     * Time: 17:00
     */

    namespace App\Services\Video;

    use App\Services\AbstractService;

    /**
     * Class ListVideos
     * List all Partner and paginate them.
     * If you want to get objects and paginate, please make your own class extend from AbstractListingObjects
     * - But we don't need paginate for Videos so that i  make this class extend from AbstractService
     *
     * @package App\Services\Video
     */
    class ListVideos extends AbstractService
    {

        protected  $query = [
            'post_type'         => 'video',
            'posts_per_page'    => -1,
            'orderby'           => 'menu_order',
            'order'             => 'asc',
        ];

        /**
         * Override parent method
         *
         * @return array
         */
        public function execute()
        {
            $data = parent::execute();
            wp_reset_query();


            return $data;

        }

    }