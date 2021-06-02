<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-07-29
 * Time: 17:00
 */

namespace App\Services\Partner;

use App\Services\AbstractService;

/**
 * Class ListPartners
 * List all Partner and paginate them.
 * If you want to get objects and paginate, please make your own class extend from AbstractListingObjects
 * - But we don't need paginate for Partners so that i  make this class extend from AbstractService
 *
 * @package App\Services\Partner
 */
class ListPartners extends AbstractService
{

    protected  $query = [
        'post_type'         => 'partner',
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