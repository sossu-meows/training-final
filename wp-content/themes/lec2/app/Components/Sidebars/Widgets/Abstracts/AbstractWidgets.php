<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-22
 * Time: 10:57
 */

namespace App\Components\Sidebars\Widgets\Abstracts;

/**
 * Class AbstractWidgets - This class is used to registering a widget
 * Ref: https://codex.wordpress.org/Widgets_API
 *
 * @package App\Components\Sidebars\Widgets\Abstracts
 */
abstract class AbstractWidgets extends \WP_Widget
{

    protected $widgetID             = 'wpb_widget';
    protected $widgetName           = 'WPBeginner Widget';
    protected $widgetDescription    = 'Sample widget based on WPBeginner Tutorial';

    /**
     * AbstractWidgets constructor.
     */
    function __construct()
    {
        parent::__construct($this->widgetID,__($this->widgetName, 'lec2_text_domain'), ['description' => __('Sample widget based on WPBeginner Tutorial', 'lec2_text_domain')]);
    }

    /**
     * Render widget into frontend
     *
     * @param array $args
     * @param array $instance
     * @return void
     */
    public function widget($args, $instance)
    {
        echo $args['before_widget'];
        $this->widgetTitle($args, $instance);
        $this->widgetContent($args, $instance);
        echo $args['after_widget'];
    }

    /**
     * Render widget title
     *
     * @param $args
     * @param $instance
     * @return void
     */
    public function widgetTitle($args, $instance){
        $title = apply_filters('widget_title', $instance['title']);
        if (!empty($title)){
            echo $args['before_title'] . $title . $args['after_title'];
        }
    }

    /**
     * Render widget content
     *
     * @param $args
     * @param $instance
     * @return void
     */
    public function widgetContent($args, $instance){
        echo __('Hello, World!', 'wpb_widget_domain');
    }

    /**
     * Widget form that will show on admin panel
     *
     * @param array $instance
     * @return string|void
     */
    public function form($instance)
    {

    }

    /**
     * Update information of a widget
     *
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    public function update($new_instance, $old_instance)
    {
        $instance = [];
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }
}