<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-06-27
 * Time: 18:20
 */
namespace App\Components\Sidebars;

use App\Components\ComponentInterface;

/**
 * Class Sidebars
 * @package App\Components\Sidebars
 */
class Sidebars implements ComponentInterface
{

   protected  $config = [
       'before_widget' => '<div class="widget-block %1$s %2$s"> <div class="widget-inner">',
       'after_widget'  => '</div></div>',
       'before_title'  => '<h4>',
       'after_title'   => '</h4>'
   ];

    public function init(){

        register_sidebar([
                'name'          => __('Footer sidebar', 'lec2_text_domain'),
                'id'            => 'sidebar-footer'
            ] + $this->config);

        register_sidebar([
                'name'          => __('Twig multiple menus', 'lec2_text_domain'),
                'id'            => 'twig-multiple-menu'
            ] + $this->config);
    }
}