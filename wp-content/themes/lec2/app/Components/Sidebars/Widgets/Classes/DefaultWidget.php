<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-22
 * Time: 17:02
 */

namespace App\Components\Sidebars\Widgets\Classes;

use App\Components\Sidebars\Widgets\Abstracts\AbstractWidgets;

/**
 * Class twigMultipleMenusWidget - This class is used to selecting multiple menus on admin panel
 * @package app\Components\Sidebars\Widgets\Classes
 */
class DefaultWidget extends AbstractWidgets
{
    protected $widgetID             = 'twig_defautl_widget';
    protected $widgetName           = 'Twig - Default widget';
    protected $widgetDescription    = 'This widget is a default widget';

    /**
     * @param array $instance
     * @return string|void
     */
    public function form($instance)
    {

        echo '<p>';
        echo __('This widget is a default widget you can clone it to create a new widget');
        echo '</pe>';

    }

    /**
     * Override parent method and load menus listing
     *
     * @param $args
     * @param $instance
     */
    public function widgetTitle($args, $instance)
    {

    }

    /**
     * @param $args
     * @param $instance
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function widgetContent($args, $instance)
    {
        dynamic_sidebar('twig-default-widget');
    }
}