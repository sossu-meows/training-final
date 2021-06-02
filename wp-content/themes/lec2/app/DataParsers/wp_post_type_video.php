<?php


    namespace App\DataParsers;
    use App\Services\Helper;

    /**
     * Data for page
     *
     * Class wp_post_type_video
     * @package App\Components\PostTypes\DataParsers
     */

    class wp_post_type_video extends wp_post_type_default
    {
        /**
         * Override parent method
         */
        public function setCustomData()
        {
            parent::setCustomData();
        }

        public function execute(){
            $this->id = $this->data->ID;
            $this->setCustomData();
            $returnData                 = (array) $this->data;
            $returnData['custom_data']  = $this->customData;
            $returnData['url']          = get_the_permalink($this->id);
            $returnData['thumbnail']    = get_the_post_thumbnail_url($this->id);

            return $returnData;
        }

    }