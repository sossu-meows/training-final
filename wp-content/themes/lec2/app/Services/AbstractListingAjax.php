<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-07
 * Time: 17:12
 */

namespace App\Services;

/**
 * This class is used to response data into Ajax listing
 *
 * Class AbstractListingAjax
 * @package App\Services
 */
abstract class AbstractListingAjax extends AbstractListingObjects
{
    protected $paged = 1;

    protected $postsPerPage = null;

    protected $totalPages = 0;

    /**
     * @param $paged
     * @return $this
     */
    public function setCurrentPage($paged){
        $this->paged = $paged;        
        return $this;
    }


    /**
     * @param $postsPerPage
     * @return $this
     */
    public function setPostsPerPage($postsPerPage){
        $this->postsPerPage = $postsPerPage;
        return $this;
    }

    /**
     * Detected the current page
     */
    public function detectCurrentPage()
    {

        $this->query['posts_per_page'] = $this->postsPerPage;
        $this->query['paged']   = $this->paged;
    }

    /**
     * Override parent's method for ajax
     *
     * @param $obj
     * @return array
     */
    public function execute()
    {
        $data = parent::execute();
        global $wp_query;
        if(empty($this->postsPerPage)){
            $this->postsPerPage = get_option( 'posts_per_page' );
        }
        $totalItems = $wp_query->found_posts;
        $currentPage = $this->query['paged'];
        $this->totalPages = ceil($totalItems / $this->postsPerPage);
        $isShowLoadMore = ($currentPage < $this->totalPages) ? true : false;
        $nextPage = $isShowLoadMore ? $currentPage + 1 : $this->totalPages;
        return [
            'data'           => $data,
            'posts_per_page' => $this->postsPerPage,
            'current_page'   => $currentPage,
            'next_page'      => $nextPage,
            'total_pages'    => $this->totalPages,
            'total_posts'    => $totalItems,
            'show_load_more' => $isShowLoadMore,
        ];
    }

    /**
     * Override parent's method for ajax of load more 4 items of News Listing
     *
     * @param $page
     * @return array
     */
    public function executeNewsData($page)
    {
        $data = parent::executeNewsData($page);
        global $wp_query;
        if(empty($this->postsPerPage)){
            $this->postsPerPage = get_option( 'posts_per_page' );
        }
        $totalItems = $wp_query->found_posts;
        $currentPage = $this->query['paged'];

        $this->totalPages = ceil($totalItems / $this->postsPerPage);
        $isShowLoadMore = ($currentPage < $this->totalPages) ? true : false;
        $nextPage = $isShowLoadMore ? $currentPage + 1 : $this->totalPages;
        return [
            'data'           => $data,
            'posts_per_page' => $this->postsPerPage,
            'current_page'   => $currentPage,
            'next_page'      => $nextPage,
            'total_pages'    => $this->totalPages,
            'total_posts'    => $totalItems,
            'show_load_more' => $isShowLoadMore,
        ];
    }
}