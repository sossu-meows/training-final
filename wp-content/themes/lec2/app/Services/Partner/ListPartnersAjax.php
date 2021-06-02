<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-07-29
 * Time: 17:00
 */

namespace App\Services\Partner;

use App\Services\AbstractListingAjax;
use App\Services\Helper;

/**
 * Class ListPartnersAjax
 * List all Partner and paginate them.
 * If you want to get objects and paginate, please make your own class extend from AbstractListingObjects
 * - But we don't need paginate for Partners so that i  make this class extend from AbstractService
 *
 * @package App\Services\Partner
 */
class ListPartnersAjax extends AbstractListingAjax
{ 
  protected  $query = [
    'post_type'         => 'partner',
    'post_status'       => 'publish',
  ];
}