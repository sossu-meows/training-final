<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-08
 * Time: 21:51
 */

namespace App\Components\Hooks\Website;


use App\Components\AcfFields\Consts\Pages\ThemeOptions;
use App\DataParsers\wp_post_type_default;
use App\Components\Hooks\AbstractFilter;
use App\Container;
use App\Services\Helper;
use App\TwigLoader;

/**
 * Register filter here
 *
 * Class Filters
 * @package App\Components\Hooks\Website
 */
class Filters extends AbstractFilter
{

    protected $functions = [
        'use_block_editor_for_post'     => 'blockEditorForPost',
        'template_include'              => ['templateInclude', PHP_INT_MAX, 1],
        'modify_post_type'              => 'modifyPostType',
        'wp_nav_menu'                   => 'wpNavMenu',
        'user_name'                     => 'userName',
        'user_profile_url'              => 'userProfileUrl',
        'nav_menu_css_class'            => ['changePageMenuClasses', 10, 2],
        'excerpt_more'                  =>  'wpdocsExcerptMore',
        'excerpt_length'                =>  'wpdocsExcerptLength',
        'woocommerce_get_price_html'    =>  ['woocommerceGetPriceHtml', 10, 2],
        'add_to_cart_redirect'          =>  'redirectToCheckout',
        'bloginfo'                      => ['changeBlogInfoTagLine', 10, 2],
        'wp_mail_content_type'          => ['setContentType', 10, 1],
        'get_term'                      => ['qTransalteApplyForTerm', 10, 2],
        'wp_enqueue_scripts'            => 'enabling_date_picker',
        'woocommerce_after_checkout_shipping_form' => ['checkoutFields', 10, 1],
        'woocommerce_checkout_after_terms_and_conditions' => ['checkoutFieldsAfterTerm', 10, 1],
        'posts_where'                   => ['training_type_where', 10, 1],
    ];

    /**
     * We don't need to use wordpress 5.** block editor in admin panel
     * @return bool
     */
    public function blockEditorForPost()
    {
        return false;
    }

    /**
     * Render page using twig
     *
     * @param $template
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function templateInclude($template)
    {
        if (!empty($template)) {
            $data = require_once  $template;

            //render twig here - false means: these twig file are loaded from frontend folder
            TwigLoader::render($data['view'], $data['data'], false);

            //this file is blank we can use it for debug from backend side
            $parserDir = Container::getInstance()->getTwigParser();
            $twigParser = "{$parserDir}/TwigParser.php";
            return $twigParser;
        }
        return $template;
    }

    /**
     * Modify a post type
     *
     * @param $post
     * @return mixed
     */
    public function modifyPostType($post)
    {
        $postType = get_post_type($post);
        $className = "App\\DataParsers\\wp_post_type_$postType";
        $obj = null;
        if (class_exists($className)) {
            $obj = new $className;
        } else {
            $obj = new wp_post_type_default();
        }
        return  $obj->setData($post)->execute();
    }

    /**
     * Get user name and format it
     *
     * @param $user
     * @return string
     */
    public function userName($user)
    {
        $userName = '';
        if (is_object($user)) {
            $userName = $user->user_nicename;
        } elseif (is_array($user)) {
            $userName = $user['user_nicename'];
        }
        $user = get_user_by('ID', $user);
        if ($user) {
            $userName = $user->user_nicename;
        }
        return ucfirst($userName);
    }

    /**
     * User profile url
     *
     * @param $user
     * @return string
     */
    public function userProfileUrl($user)
    {
        $title  = $this->userName($user);
        $id     = $user;
        if (is_array($user)) {
            $id = $user['ID'];
        } elseif (is_object($user)) {
            $id = $user->ID;
        }
        $url    = get_edit_user_link($id);
        return "<a href='{$url}'>{$title}</a>";
    }

    /**
     * Modify menu item
     *
     * @param $menu
     * @return string|string[]|null
     */
    public function wpNavMenu($menu)
    {
        $menu = preg_replace('/ class="sub-menu"/', '/ class="nav-menu-sub" /', $menu);
        return $menu;
    }

    /**
     * Jobs search menu will be activated if current page is a single job.
     *
     * @param $menu
     * @param $item
     * @return array|mixed
     */
    public function changePageMenuClasses($menu, $item)
    {
        global $post;
        $postType = get_post_type($post);
        if ($postType == \App\Components\AcfFields\Consts\PostTypes\Job::_NAME) {
            // remove all current_page_parent classes
            $menu = str_replace('current-menu-item', '', $menu);

            if (strpos($item->url, $postType) !== false) {
                $menu[] = 'current-menu-item';
            }
        }

        if (strpos($item->url, $_SERVER["REQUEST_URI"]) !== false) {
            if ($_SERVER["REQUEST_URI"] == '/') {
                $menu = str_replace('current-menu-item', '', $menu);
            } else {
                $menu[] = 'current-menu-item';
            }
        }
        if ($postType == 'post' && $menu[4] == 'menu-item-183') {
            $menu[] = 'current-menu-item';
        }
        if (strpos($_SERVER["REQUEST_URI"], 'training') !== false && strpos($item->post_name, 'training') !== false) {
            $menu[] = 'current-menu-item';
        }
        if (strpos($_SERVER["REQUEST_URI"], 'partner') !== false && strpos($item->url, 'partner') !== false) {
            $menu[] = 'current-menu-item';
        }
        return $menu;
    }

    /**
     * Modify the more icon
     *
     * @param $more
     * @return  string
     */
    public function wpdocsExcerptMore($more)
    {
        return '...';
    }

    /**
     * Modify the more icon
     *
     * @param $more
     * @return  string
     */
    public function wpdocsExcerptLength($length)
    {
        return 30;
    }


    /**
     * Modify site title and tag line from theme options
     *
     * @param $text
     * @param $show
     * @return mixed
     */
    public function changeBlogInfoTagLine($text, $show)
    {

        $themeOptions           = Container::getInstance()->getThemeOptions();
        $textFromThemeOptions   = isset($themeOptions[ThemeOptions::_WEBSITE][$show]) ? $themeOptions[ThemeOptions::_WEBSITE][$show] : $text;

        return $textFromThemeOptions;
    }

    public function setContentType()
    {
        return "text/html";
    }

    public function redirectToCheckout()
    {
        global $woocommerce;
        $checkout_url = $woocommerce->cart->get_checkout_url();
        return $checkout_url;
    }

    public function woocommerceGetPriceHtml($price, $product)
    {
        if ($price == wc_price(0.00))
            return 'free';
        else
            return $price;
    }

    public function qTransalteApplyForTerm($term, $taxonomies)
    {
        if (function_exists("qtranxf_useCurrentLanguageIfNotFoundUseDefaultLanguage")) {
            $term->description = qtranxf_useCurrentLanguageIfNotFoundUseDefaultLanguage($term->description);
        }
        return $term;
    }

    public function checkoutFields($checkout)
    {
        echo '
        <script>
            jQuery(function($){
                $("#arrival_date, #departure_date").datepicker();
            });
        </script>';

        woocommerce_form_field('in_house_training', array(
            'type'          => 'checkbox',
            'class'         => array('in_house_training form-row-wide'),
            'label'   => __('I ask for an offer for in-house training.'),
        ), $checkout->get_value('in_house_training'));

        woocommerce_form_field('room_reservation', array(
            'type'          => 'checkbox',
            'class'         => array('room_reservation form-row-wide'),
            'label'   => __('Room reservations in the conference hotel are desirable.'),
        ), $checkout->get_value('room_reservation'));

        // buy as gift lable
        woocommerce_form_field('buy_as_gift_client', array(
            'type'          => 'checkbox',
            'class'         => array('buy_as_gift_client form-row-wide'),
            'label'   => __('Buy as gift !'),
        ), $checkout->get_value('buy_as_gift_client'));

        echo '<div class="room-reservation"><h4>Room reservation</h4>';
        echo '<div role="wrapper" class="gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group">';
        woocommerce_form_field('arrival_date', array(
            'type'          => 'text',
            'class'         => array('arrival_date form-row-wide'),
            'id'            => 'arrival_date',
            'required'      => true,
            'placeholder'   => __('Arrival date'),
        ), $checkout->get_value('arrival_date'));
        echo '<span class="input-group-append" role="right-icon"><button class="btn btn-outline-secondary border-left-0" type="button"><i class="gj-icon">event</i></button></span></div>';

        echo '<div role="wrapper" class="gj-datepicker gj-datepicker-bootstrap gj-unselectable input-group">';
        woocommerce_form_field('departure_date', array(
            'type'          => 'text',
            'class'         => array('departure_date form-row-wide'),
            'id'            => 'departure_date',
            'required'      => true,
            'placeholder'   => __('Departure date'),
        ), $checkout->get_value('departure_date'));
        echo '<span class="input-group-append" role="right-icon"><button class="btn btn-outline-secondary border-left-0" type="button"><i class="gj-icon">event</i></button></span></div>';

        echo '</div>';
    }

    public function checkoutFieldsAfterTerm($checkout)
    {
        //        woocommerce_form_field( 'subscribe_newsletter', array(
        //            'type'          => 'checkbox',
        //            'class'         => array('subscribe_newsletter form-row-wide'),
        //            'label'   => __('Yes, I would like to subscribe to the LEC2 newsletter. You can find more detailed information in our privacy policy.'),
        //        ), $checkout->get_value( 'subscribe_newsletter' ));
        //
        //        woocommerce_form_field( 'pass_personal_data', array(
        //            'type'          => 'checkbox',
        //            'class'         => array('pass_personal_data form-row-wide'),
        //            'label'   => __('LEC2 may pass on my personal data (name; email address; company name; company address) to Lattice Semiconductor Corp., 5555 NE Moore Ct., Hilsboro, OR 97127 for contact purposes by Lattice Corp.'),
        //        ), $checkout->get_value( 'pass_personal_data' ));
    }

    public function enabling_date_picker()
    {

        // Only on front-end and checkout page
        if (is_admin() || !is_checkout()) return;

        // Load the datepicker jQuery-ui plugin script
        wp_enqueue_script('jquery-ui-datepicker');
        wp_register_style('jquery-ui', '//ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');
        wp_enqueue_style('jquery-ui');
    }

    public function training_type_where($where)
    {
        $where = str_replace(
            array(
                "meta_key = 'training_types_&&_training_type'",
                "meta_key = 'training_types_&&_execution_of_training_live_course_dates_&&_date'",
                "meta_key = 'training_types_&&_execution_of_training_has_recorded_video'",
                "meta_key = 'training_types_&&_execution_of_training_has_live_course'"
            ),
            array(
                "meta_key LIKE 'training_types_%_training_type'",
                "meta_key LIKE 'training_types_%_execution_of_training_live_course_dates_%_date'",
                "meta_key LIKE 'training_types_%_execution_of_training_has_recorded_video'",
                "meta_key LIKE 'training_types_%_execution_of_training_has_live_course'"
            ),
            $where
        );
        return $where;
    }
}
