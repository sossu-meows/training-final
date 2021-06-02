<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-08
 * Time: 16:06
 */

namespace App\DataParsers;

use App\Services\Helper;

/**
 * Data for page
 *
 * Class wp_post_type_job
 * @package App\Components\PostTypes\DataParsers
 */
class wp_post_type_product extends wp_post_type_default
{
    /**
     * Override parent method
     */
    public function setCustomData()
    {
		parent::setCustomData();
    }

    public function execute() {
        $this->id = $this->data->ID;
        $this->setCustomData();

        $returnData                 = (array) $this->data;
        $returnData['custom_data']  = $this->customData;
        $returnData['url']          = get_the_permalink($this->id);
        $returnData['thumbnail']    = get_the_post_thumbnail_url($this->id);
         /**
	     * Override training type datas if user setup in product details
	     *
	     */
        if ($returnData['custom_data']['training_types']) {
            foreach ($returnData['custom_data']['training_types'] as $key => $data) {
                $training_type = (array) $data['training_type'];
                unset($data['training_type']);
                $returnData['custom_data']['training_types'][$key] = array_merge($training_type, $data);
                $returnData['custom_data']['training_types'][$key]['thumbnail'] = get_the_post_thumbnail_url($returnData['custom_data']['training_types'][$key]['ID']);
            }
        }
        
        return $returnData;
    }
}


