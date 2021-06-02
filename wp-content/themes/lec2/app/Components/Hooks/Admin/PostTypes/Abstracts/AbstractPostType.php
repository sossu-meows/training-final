<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-09
 * Time: 12:11
 */

namespace App\Components\Hooks\Admin\PostTypes\Abstracts;

/**
 * Class AbstractPostType - Init a new post type
 *
 * @package App\Components\Hooks\Admin\PostTypes\Abstracts
 */
abstract class AbstractPostType extends AbstractPostTypeConfigurations
{

    protected $screenId;

    /***
     * Init a post type
     */
    public function init(){
        $this->screenId = $screenId = "edit.php?post_type={$this->name}";
        $this->registerPostType();
        //custom admin columns here
        add_filter('manage_'.$this->name.'_posts_columns', [$this,'adminColumns'], 10);
        //custom column content
        add_action('manage_'.$this->name.'_posts_custom_column', [$this,'adminColumnsContent'], 10, 2);
        //sortable by column
        add_filter('manage_'.$screenId.'_sortable_columns', [$this, 'sortableColumns']);
        //modify table's header on admin panel
        add_filter("views_{$this->screenId}",[$this,'viewsScreen']);
        $this->selfHook();
    }

    /**
     * The self hook functions of each child class
     *
     * @return mixed
     */
    public abstract function selfHook();

    /**
     * Sortable columns
     *
     * @param $columns
     * @return array
     */
    public function sortableColumns($columns){
        return array_merge($columns, $this->initSortableColumns());
    }

    /**
     * All customize sortable columns will be defined here.
     *
     * @return array
     */
    public function initSortableColumns(){
        return [];
    }

    /**
     * Admin columns
     *
     * @param $defaults
     * @return mixed
     */
    public abstract function adminColumns($defaults);

    /**
     * Content of these created columns
     *
     * @param $columnName
     * @param $postID
     * @return mixed
     */
    public abstract function adminColumnsContent($columnName, $postID);

    /**
     * Modify the header of admin table, (All (122) | Mine (123) | ....)
     *
     * @param $views
     * @return mixed
     */
    public  function  viewsScreen($views){
        return $views;
    }

}