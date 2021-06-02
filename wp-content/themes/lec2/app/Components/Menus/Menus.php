<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-06-27
 * Time: 18:30
 */

namespace App\Components\Menus;

use App\Components\ComponentInterface;

/**
 * Register navigation menus (menu location)
 * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
 */
class Menus implements ComponentInterface
{
    public function init(){

        register_nav_menus([
            'primary_navigation' => __('Primary Navigation', 'sage'),
        ]);

    }
}