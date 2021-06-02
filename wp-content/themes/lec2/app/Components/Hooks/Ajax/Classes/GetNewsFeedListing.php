<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-14
 * Time: 16:33
 */

namespace App\Components\Hooks\Ajax\Classes;

use App\Components\Hooks\Ajax\AbstractAjax;
use App\Services\Post\ListPostAjax;
/**
 * Class GetNewsFeedListing - Get more post
 *
 * @package App\Components\Hooks\Ajax\Classes
 */
class GetNewsFeedListing extends AbstractAjax
{
    protected $functions = [ 'get_more_post' =>  'getMorePost'];

    /**
     * getMorePost
     */
    public function getMorePost(){
        $getPostListing = new ListPostAjax();
        $getPostListing->setCurrentPage($_POST['pageNumber']);
        $getPostListing->setPostsPerPage($_POST['postsPerPage']);

        if ($_POST['postsPerPage'] == 4) {
            $result = $getPostListing->executeNewsData($_POST['pageNumber']);
        } else {
            $result = $getPostListing->execute();
        }

        if($result){
            wp_send_json($result);
        } else {
            wp_send_json(array(
                'status' =>  false
        ));
      }
    }
}