<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-07-29
 * Time: 17:00
 */

namespace App\Services\Office;

use App\Components\AcfFields\Consts\PostTypes\Office;
use App\Services\AbstractService;

/**
 * Class ListOffices
 * List all Office and paginate them.
 * If you want to get objects and paginate, please make your own class extend from AbstractListingObjects
 * - But we don't need paginate for offices so that i  make this class extend from AbstractService
 *
 * @package App\Services\Office
 */
class ListOffices extends AbstractService
{

    protected  $query = [
        'post_type'         => Office::_NAME,
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