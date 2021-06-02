<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-07-29
 * Time: 17:00
 */

namespace App\Services\Training;

use App\Services\AbstractService;

/**
 * Class ListTrainings
 * List all Training and paginate them.
 * If you want to get objects and paginate, please make your own class extend from AbstractListingObjects
 * - But we don't need paginate for training so that i  make this class extend from AbstractService
 *
 * @package App\Services\Training
 */
class ListTrainings extends AbstractService
{

    protected  $query = [
        'post_type'         => 'product',
        'posts_per_page'    => 10,
        'orderby'           => 'menu_order',
        'order'             => 'asc',
    ];

    public function parseData($obj)
    {
        return $obj;
    }
    /**
     * Override parent method
     *
     * @return array
     */
    public function execute()
    {
        $data = parent::execute();
        $returnData = array();
        foreach ($data as $key => $item) {
            $item->id             = $item->ID;
            $item                 = (array) $item;
            $item['url']          = get_the_permalink($item["id"]);
            $item['thumbnail']    = get_the_post_thumbnail_url($item["id"]);
            $returnData[] = $item;
        }
        wp_reset_postdata();
        return $returnData;
    }
}