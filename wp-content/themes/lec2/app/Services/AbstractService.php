<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-07-09
 * Time: 15:42
 */
namespace App\Services;

/**
 * Class AbstractService - all service classed will extend this class
 * @package App\Services
 */
abstract class AbstractService
{

    protected $query = [];
    protected $paged = [];

    protected $postsFound;

    /**
     * @return mixed
     */
    public function getPostsFound() {
        return $this->postsFound;
    }

    /**
     * @return array
     */
    public function getQuery()
    {
        return $this->query;
    }
    public function getPage()
    {
        return $this->paged;
    }

    /**
     * @param array $paged
     * @return AbstractService
     */
    public function setPage($paged)
    {
        $this->paged = $paged;
        return $this;
    }

    protected $parseDataToArray = false;

    /**
     * Detect current page
     */
    public function detectCurrentPage() {
        $this->query['paged'] = (get_query_var('paged')) ? get_query_var('paged') : 1;
    }

    /**
     * Override function of parent class
     *
     * @return array
     */
    public function execute()
    {
        global $wp_query;
        $this->detectCurrentPage();
        $this->makeFilter();

        // The Query
        $objs = query_posts($this->query);

        $returnData = [];

        if (is_array($objs) && count($objs) > 0) {
            foreach ($objs as $obj) {
                $returnData[] = $this->parseData($obj);
            }
        }

        $this->postsFound = $wp_query->found_posts;

        wp_reset_postdata();
        return $returnData;
    }

    /**
     * Override function of parent class
     *
     * @return array
     */
    public function executeNewsData($page)
    {
        global $wp_query;

        $this->query['posts_per_page']  = 4;
        $this->query['paged']           = $page + 2;

        $objs       = query_posts($this->query);
        $returnData = [];

        if(is_array($objs) && count($objs) > 0){
            foreach ($objs as $obj){
                $returnData[] = $this->parseData($obj);
            }
        }

        $this->postsFound = $wp_query->found_posts;

        wp_reset_postdata();
        return $returnData;
    }

    /**
     * Override function of parent class
     *
     * @param $obj
     * @return array
     */
    public function parseData($obj)
    {
        $data = apply_filters("modify_post_type", $obj);
        return $data;
    }

    /**
     * Use this function to make query filter
     * @return void
     */
    public function makeFilter() {
        $key = isset($_GET['search']) ? $_GET['search'] : null ;
        $taxonomyID = isset($_GET['training_cat_id']) ? $_GET['training_cat_id'] : null;
        
        if (!empty($key)) {
            $this->query['s'] = $key;
        }

        if (!empty($taxonomyID)) {
            $this->query['tax_query'] = [
                array(
                    'taxonomy'  => 'product_cat',
                    'field'     => 'term_id',
                    'terms'     => $taxonomyID,
                    'operator'  => 'IN'
                ),
            ];
        }
    }
}
