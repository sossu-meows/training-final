<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-06-27
 * Time: 18:08
 */

namespace App\Components;

/**
 * Separate this folder, because i want to reuse and manage its components locally.
 */

use App\Components\AcfFields\RegisterFields;
use App\Components\Hooks\RegisterHooks;

/**
 * Class Components
 *
 * @package App\Components
 */
class Components
{
    /**
     * Register post types
     */
    public function init()
    {
        $this->registerShortCodes();
        $this->initAcfFields();

        $hooks = new RegisterHooks();
        $hooks->init();

        //These line below is used to fix  "user_can_access_admin_page", please refer this link https://core.trac.wordpress.org/ticket/29714
        global $pagenow;

        if ( $pagenow == "edit.php" && isset( $_REQUEST['post_type'] ) ) 
        {
            if($_REQUEST['post_type'] !== 'acf-field-group' && $_REQUEST['post_type'] !== 'shop_order')
            {
                $pagenow .= '?post_type=' . $_REQUEST['post_type'];
            }
        }
    }

    /**
     * Register short codes
     */
    public function registerShortCodes()
    {
        $shortCodes = [

        ];

        if(count($shortCodes)>0){
            foreach ($shortCodes as $shortCode){
                $shortCode->init();
            }
        }
    }

    /**
     * Init new ACFField group
     */
    public function initAcfFields()
    {
        $fields = new RegisterFields();
        $fields->init();
    }
}
