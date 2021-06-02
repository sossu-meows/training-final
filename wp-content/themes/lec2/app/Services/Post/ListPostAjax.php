<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-07-29
 * Time: 17:00
 */

namespace App\Services\Post;

use App\Services\AbstractListingAjax;

/**
 * Class ListPostAjax
 * List all Post and paginate them.
 * If you want to get objects and paginate, please make your own class extend from AbstractListingObjects
 * - But we don't need paginate for Partners so that i  make this class extend from AbstractService
 *
 * @package App\Services\Post
 */
class ListPostAjax extends AbstractListingAjax
{ 
  protected  $query = [
    'post_type'         => 'post',
    'post_status'       => 'publish',
    'orderby'           => 'date',
    'order'             => 'DESC',
  ];
}