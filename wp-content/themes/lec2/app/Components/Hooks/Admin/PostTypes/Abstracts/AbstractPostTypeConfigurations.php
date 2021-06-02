<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-09
 * Time: 12:02
 */

namespace App\Components\Hooks\Admin\PostTypes\Abstracts;

use App\Components\Roles\Capacities;
use App\Services\Helper;

/**
 * Class AbstractPostTypeConfigurations - Configurations for a post type here
 *
 * @package App\Components\Hooks\Admin\PostTypes\Abstracts
 */
abstract class AbstractPostTypeConfigurations extends AbstractPostTypeProperties
{
    /**
     * AbstractPostTypeConfigurations constructor.
     */
    public function __construct()
    {
        $this->tablePrefix = Helper::getTablePrefix();
        $this->useCategory = false;
        $this->currentUser = wp_get_current_user();

        if(isset($_GET['orderby']) && isset($_GET['order'])){
            $this->orderBy = $_GET['orderby'];
            $this->order = $_GET['order'];
        }
    }


    /**
     * Register post type
     */
    public function registerPostType(){
        if (!$this->support) {
            $this->support = array('title','thumbnail','editor','custom-fields');
        }
        $this->singleName = isset($this->singleName)?$this->singleName:$this->label;
        $labels = array(
            'name'                => __( $this->label, "lec2_text_domain" ),
            'singular_name'       => __( isset($this->singleName)?$this->singleName:$this->label, "lec2_text_domain" ),
            'menu_name'           => __( $this->label, "lec2_text_domain" ),
            'name_admin_bar'      => __( $this->label, "lec2_text_domain" ),
            'parent_item_colon'   => __( 'Parent Item:', "lec2_text_domain" ),
            'all_items'           => __( 'All '.$this->label, "lec2_text_domain" ),
            'add_new_item'        => __( 'Add New '.$this->singleName, "lec2_text_domain" ),
            'add_new'             => __( 'Add New '.$this->singleName, "lec2_text_domain" ),
            'new_item'            => __( 'New Item', "lec2_text_domain" ),
            'edit_item'           => __( 'Edit Item', "lec2_text_domain" ),
            'update_item'         => __( 'Update Item', "lec2_text_domain" ),
            'view_item'           => __( 'View Item', "lec2_text_domain" ),
            'search_items'        => __( 'Search '.$this->label, "lec2_text_domain" ),
            'not_found'           => __( 'Not found', 'text_domain' ),
            'not_found_in_trash'  => __( 'Not found in Trash', "lec2_text_domain" ),
        );

        $args = array(
            'label'               => __( $this->name, "lec2_text_domain" ),
            'description'         => __( $this->name.' Description', "lec2_text_domain" ),
            'labels'              => $labels,
            'supports'            => $this->support ,
            //'capabilities'          => Capacities::buildCapacities($this->name),
            'hierarchical'        => true,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 5,
            'menu_icon'           => $this->menuIcon,
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => true,
            'publicly_queryable'  => true,
        );

        register_post_type( $this->name, $args );
        //admin can be see the created post-type automatically
        //add_action( 'admin_init', [$this, 'addThemeCaps']);
    }

    /**
     * @param $taxName
     * @param $taxLabel
     * @param $taxSingularLabel
     * @param bool $isCategory - it means  isCategory or tag
     */
    public function registerTax($taxName, $taxLabel, $taxSingularLabel, $isCategory = true){
        if(!empty($taxName) && !empty($taxLabel)):
            $labels = array(
                'name'              => __( $taxLabel,  "lec2_text_domain" ),
                'singular_name'     => __( $taxSingularLabel , "lec2_text_domain" ),
                'search_items'      => __( 'Search '.$taxLabel,   "lec2_text_domain"  ),
                'all_items'         => __( 'All '.$taxLabel,  "lec2_text_domain"  ),
                'parent_item'       => __( 'Parent '.$taxSingularLabel,  "lec2_text_domain"  ),
                'parent_item_colon' => __( 'Parent '.$taxSingularLabel.':',  "lec2_text_domain"  ),
                'edit_item'         => __( 'Edit '.$taxSingularLabel,  "lec2_text_domain"  ),
                'update_item'       => __( 'Update '.$taxLabel,  "lec2_text_domain"  ),
                'add_new_item'      => __( 'Add New '.$taxSingularLabel,  "lec2_text_domain"  ),
                'new_item_name'     => __( 'New Genre '.$taxSingularLabel,  "lec2_text_domain"  ),
                'menu_name'         => __( $taxLabel,  "lec2_text_domain"  ),
            );
            $args = array(
                'hierarchical'      => $isCategory, //Indicate category or tax
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array( 'slug' => $taxName ),
            );

            register_taxonomy($taxName, $this->name, $args );

        endif;
    }

    /**
     * Admin can load this post type automatically
     */
//    public function addThemeCaps() {
//        $admins = get_role( 'administrator' );
//        foreach (Capacities::buildCapacities($this->name) as $k => $name){
//            $admins->add_cap($name);
//        }
//    }

    /**
     * Check this is not administrator
     *
     * @return bool
     */
    protected function isNotAdminRole(){

        if(!Helper::isAdministrator($this->currentUser->roles)){
            return true;
        }
        return false;
    }

    /**
     * Check current page is an admin page
     *
     * @return bool
     */
    protected function isAdminPage(){
        global $pagenow, $wp_query;
        //prevent this function run outside admin panel and prevent it can't run outside the specific post-type.
        if(strpos($pagenow,$this->name) !== false &&  strpos($pagenow,'edit.php') !== false && $wp_query->is_admin ){
            return true;
        }
        return false;
    }
}