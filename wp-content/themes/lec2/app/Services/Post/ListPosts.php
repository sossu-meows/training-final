<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-07-09
 * Time: 15:59
 */

namespace App\Services\Post;


use App\Services\AbstractListingObjects;

/**
 * Class ListPosts
 *
 * List all jobs and paginate them.
 * If you want to get objects and paginate, please make your own class extend from AbstractListingObjects
 *
 * @package App\Services\Post
 */
class ListPosts extends AbstractListingObjects
{
    protected  $query = [
        'post_type' => 'post'
    ];
}
