<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-07-25
 * Time: 00:38
 */

namespace App\Components\Twig;

use App\Components\AcfFields\Consts\Pages\ThemeOptions;
use App\Container;
use App\Services\Helper;
use App\Services\Training\ListTrainingsAjax;

/**
 * Class Twig
 * @package App\Components\Twig
 */
class Twig extends AbstractTwig
{
    /**
     * Wrap these functions for twig
     */
    public function parsedFunctions()
    {
        $this->function[] = new \Twig_SimpleFunction('get_term_link', function ($term, $taxonomy) {
            get_term_link( $term, $taxonomy );
        });

        $this->function[] = new \Twig_SimpleFunction('dynamic_sidebar', function ($sidebarId) {
            if(is_active_sidebar($sidebarId)){
                dynamic_sidebar($sidebarId);
            }
        });

        $this->function[] = new \Twig_SimpleFunction('language_attributes', function () {
            language_attributes();
        });

        $this->function[] = new \Twig_SimpleFunction('blog_info', function ($name) {
            bloginfo($name);
        });

        $this->function[] = new \Twig_SimpleFunction('wp_nav_menu', function ($menuName, $menuClass) {
            if(has_nav_menu($menuName)){
                wp_nav_menu(['theme_location' => $menuName, 'menu_class' => $menuClass]);
            }
        });

        $this->function[] = new \Twig_SimpleFunction('posts_navigation', function () {
            return Helper::pagination();
        });

        $this->function[] = new \Twig_SimpleFunction('wp_head', function () {
            wp_head();
        });

        $this->function[] = new \Twig_SimpleFunction('wp_footer', function () {
            wp_footer();
        });

        $this->function[] = new \Twig_SimpleFunction('body_class', function ($class='') {
            body_class($class);
        });

        $this->function[] = new \Twig_SimpleFunction('home_url', function ($path) {
            home_url($path);
        });

        $this->function[] = new \Twig_SimpleFunction('get_search_form', function () {
            get_search_form();
        });

        $this->function[] = new \Twig_SimpleFunction('do_shortcode', function ($shortCode) {
            echo do_shortcode($shortCode);
        });

        $this->function[] = new \Twig_SimpleFunction('the_posts_pagination', function ($pagination) {
            the_posts_pagination($pagination);
        });

        $this->function[] = new \Twig_SimpleFunction('dump', function ($value) {
            if ($_GET['dump'] == 'json' && WP_DEBUG){
                $value = "<script> console.log('%c SERVER LOG:', 'color:red;font-weight:bold;',".json_encode($value).");</script>";
                print_r($value);
            }
        });

        $this->function[] = new \Twig_SimpleFunction('log', function ($value) {
            if(WP_DEBUG){
                $value = "<script> console.log('%c SERVER LOG:', 'color:red;font-weight:bold;',".json_encode($value).");</script>";
                print_r($value);
            }
        });

        $this->function[] = new \Twig_SimpleFunction('fe_assets', function ($path) {
          $feAssetUrl =   Container::getInstance()->getAssetFolder('frontend');
          return "{$feAssetUrl}/{$path}";

        });
    }

    /**
     * Wrap these filters for twig
     */
    public function parsedFilter()
    {
       $this->filters[] = new \Twig_SimpleFilter('trans',function($text){
            return  __($text,'lec2_text_domain');
       });

       $this->filters[] = new \Twig_SimpleFilter('content',function($text){
            return  apply_filters('the_content',$text);
       });

        /** format the content of ACF Wysiwyg Editor */
        $this->filters[] = new \Twig_SimpleFilter('contentFormat',function($text){
            return  apply_filters('acf_the_content',$text);
        });

       $this->filters[] = new \Twig_SimpleFilter('esc_url',function($text){
            return esc_url( __($text,'lec2_text_domain'));
       });

       $this->filters[] = new \Twig_SimpleFilter('edit_user_url',function($user){
            return apply_filters('user_profile_url',$user);
       });
    }

    /**
     * Global function will be pushed into Twig
     */
    public function parsedGlobal()
    {
        $this->global = [
            'global' => [
                'home_url'          =>  home_url('/'),
                'page_title'        =>  get_the_title(),
                'blog_name'         =>  get_bloginfo('name'),
                'site_description'  =>  get_bloginfo('description'),
                'ajax_url'          =>  admin_url('admin-ajax.php'),
                'admin_url'         =>  admin_url(),
                'wp_include'        =>  includes_url(),
                'asset_uri'         =>  Container::getInstance()->getAssetFolder(),
                'fe_assets_url'     =>  Container::getInstance()->getAssetFolder('frontend'),
                'theme_options'     =>  Container::getInstance()->getThemeOptions(),
                'languages'         => $this->generateLanguagesAvailableUrl(),
                'newsletter'        => [
                    'newsletter_en'        => do_shortcode('[email-subscribers-form id="1"]'),
                    'newsletter_de'        => do_shortcode('[email-subscribers-form id="2"]')
                ],
                'filter_shorties'   => $this->getTrainingCats(),
                'filter_modules'    => $this->getTrainingModules(),
                'filter_schedule'   => $this->getTrainingBySchedule(),
            ]

        ];
    }

    /**
     * Generate languages available url
     *
     * @return array
     */
    private function generateLanguagesAvailableUrl()
    {
        if (is_plugin_active('qtranslate-x/qtranslate.php')) {
        // Get global config of qtranslate
            global $q_config;
            $url = is_404() ? get_option('home') : $url = '';

            // Get current language
            $current = $q_config['language'];

            // Create url list language
            $list = [];
            foreach(qtranxf_getSortedLanguages() as $language) {
                $list[$language] = [
                    'title' => $q_config['language_name'][$language],
                    'url'   => qtranxf_convertURL($url, $language, false, true)
                ];
            }

            return ['current' => $current, 'list' => $list];
        }
    }

    /**
     * @return array
     */
    private function getTrainingCats() {
        $productCats    = new \App\Services\ProductCat\ListProductCats();
        $cats           = $productCats->execute();
        array_unshift($cats, array("label" => "All", "value" => ""));

        return $cats;
    }

    /**
     * @return array
     */
    private function getTrainingModules() {

        $productCats    = new \App\Services\ProductCat\ListProductCats();
        $catListing     = $productCats->execute();
        array_unshift($catListing, array("label" => "All", "value" => ""));

        $trainingType   = new \App\Services\TrainingType\ListTrainingTypes();
        $typesListing   = $trainingType->executeFilter();
        array_unshift($typesListing, array("label" => "All", "value" => ""));

        return ['training_cat' => $catListing, 'training_type' => $typesListing];
    }

    /**
     * @return array
     */
    private function getTrainingBySchedule() {
        $types = [
            ['label' => "All", "value" => "all"],
            ['label' => "Keyword", "value" => "type"],
            ['label' => "Location (coming soon)", "value" => "location"],
            ['label' => "Date", "value" => "date"],
        ];

        $location = [
            ['label' => "Berlin", "value" => 1],
            ['label' => "Paris", "value" => 2],
            ['label' => "New York", "value" => 3],
            ['label' => "Rome", "value" => 4]
        ];

        return ['types' => $types, 'location' => $location];
    }
}