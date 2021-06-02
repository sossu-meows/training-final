<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-07-29
 * Time: 17:00
 */

namespace App\Services\ProductCat;

/**
 * Class ListProductCats
 * List all Product Categories.
 * If you want to get objects and paginate, please make your own class extend from AbstractListingObjects
 * - But we don't need paginate for training so that i  make this class extend from AbstractService
 *
 * @package App\Services\Training
 */
class ListProductCats
{

    /**
     * Override parent method
     *
     * @return array
     */
    public function execute()
    {
        $data = array();
        $categories = get_categories(array(
            'taxonomy' => 'product_cat',
            'orderby' => 'name',
            'order'   => 'ASC'
        ));
        
        foreach( $categories as $category ) {
            $data[] = array(
                "label" => $category->name,
                "value" => $category->term_id
            );
        } 
        return $data;
    }
}