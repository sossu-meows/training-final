<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-07-25
 * Time: 17:40
 */

namespace App\Services;

/**
 * Class AbstractSingleObject - Single object
 * @package App\Services
 */
abstract class AbstractSingleObject extends AbstractService
{

    /**
     * Execute function
     *
     * @return array|\WP_Query|null
     */
    public function execute()
    {
        $returnData = null;
        while (have_posts()){
            the_post();
            $post = get_post();
            $returnData = $this->parseData($post);
        }

        return $returnData;
    }

}