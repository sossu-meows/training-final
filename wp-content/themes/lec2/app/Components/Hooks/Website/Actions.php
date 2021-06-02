<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-08
 * Time: 22:00
 */

namespace App\Components\Hooks\Website;


use App\Components\AcfFields\Consts\Pages\ThemeOptions;
use App\Components\Hooks\AbstractHook;
use App\Components\Hooks\Admin\PostTypes\RegisterPostTypes;
use App\Components\Menus\Menus;
use App\Components\Sidebars\Sidebars;
use App\Container;

/**
 * Action
 *
 * Class Actions
 * @package App\Components\Hooks\Website
 */
class Actions extends AbstractHook
{

    protected  $functions = [
        'init'                  => 'actionInit',
        'widgets_init'          => 'initSidebars',
        'after_setup_theme'     => 'afterSetupTheme',
        'wp_enqueue_scripts'    => 'enqueueScripts',
        'phpmailer_init'        => 'enablePhpMailer',
        'woocommerce_checkout_update_order_meta' => ['checkout_field_update_order_meta',10,2],
        'woocommerce_admin_order_data_after_billing_address', ['lec2_checkout_field_display_admin', 20,1],
    ];

    /**
     * This function will be called by init action
     */
    public function actionInit(){
       
        $this->initPostType();
        $themeOptions = Container::getInstance()->getThemeOptions();
        $apiKey = isset($themeOptions[ThemeOptions::_WEBSITE][ThemeOptions::_GOOGLE_API_KEY])?$themeOptions[ThemeOptions::_WEBSITE][ThemeOptions::_GOOGLE_API_KEY]:'';
        if(!empty($apiKey)){
            acf_update_setting('google_api_key', $apiKey);
        }
    }

    /**
     * Init theme components
     */
    public function initPostType(){
        $postTypes = new RegisterPostTypes();
        $postTypes->init();
    }

    /**
     * Init sidebars
     */
    public function initSidebars(){
        $sideBar = new Sidebars();
        $sideBar->init();
    }

    /**
     * After setup theme
     */
    public function afterSetupTheme(){
        /**
         * Enable features from Soil when plugin is activated
         * @link https://roots.io/plugins/soil/
         */
        add_theme_support('soil-clean-up');
        add_theme_support('soil-jquery-cdn');
        add_theme_support('soil-nav-walker');
        add_theme_support('soil-nice-search');
        add_theme_support('soil-relative-urls');

        /**
         * Enable plugins to manage the document title
         * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
         */
        add_theme_support('title-tag');

        /**
         * Enable post thumbnails
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        /**
         * Enable HTML5 markup support
         * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
         */
        add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

        /**
         * Enable selective refresh for widgets in customizer
         * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
         */
        add_theme_support('customize-selective-refresh-widgets');

        /**
         * Use main stylesheet for visual editor
         * @see resources/assets/styles/layouts/_tinymce.scss
         */
        //add_editor_style(asset_path('styles/main.css'));

        load_theme_textdomain( 'lec2_text_domain', Container::getInstance()->getLangFolder() );
        load_theme_textdomain( 'acf', Container::getInstance()->getLangFolder() );

        /**
         * Add option page
         */
        if (function_exists('acf_add_options_page')) {

            $settings = [
                'page_title'    => __('Theme Options','lec2_text_domain'),
                'menu_title'    => __('Theme Options','lec2_text_domain'),
                'update_button' => __('Update', 'lec2_text_domain'),
                'capability'    => 'edit_pages',
                'menu_slug'     => 'acf-options',
            ];
            acf_add_options_page($settings);

        }

        $menu = new Menus();
        $menu->init();
    }

    /**
     * Theme assets
     */
    public function enqueueScripts(){

        $assetFolder    = Container::getInstance()->getAssetFolder('frontend');
        $viewFolder     = Container::getInstance()->getViewsFolder();
        $assetContent   =  "{$viewFolder}/frontend/dist/assets/assets.json";
        $json           =  file_get_contents($assetContent);
        $data           = json_decode($json, true);

        //enqueue script
        $scripts        = isset($data['scripts']) ? $data['scripts'] : [];
        foreach ($scripts as $k => $name){

            wp_enqueue_script("{$k}-{$name}", "{$assetFolder}/{$name}", ['jquery'], null, true);
        }

        //enqueue styles
        $styles         = isset($data['styles']) ? $data['styles'] : [];
        foreach ($styles as $k => $name){
            wp_enqueue_style("{$k}-{$name}", "{$assetFolder}/{$name}",false, true);
        }

    }

    /**
     * This is used to enable php mailer
     *
     * @param $phpMailer
     */
    public function enablePhpMailer($phpMailer){

        $easySmtpOptions = get_option( 'swpsmtp_options' );

        $phpMailer->isSMTP();
        $phpMailer->Host        =   isset($easySmtpOptions['smtp_settings']['host']) ?$easySmtpOptions['smtp_settings']['host']:'';
        $phpMailer->SMTPSecure  =   isset($easySmtpOptions['smtp_settings']['type_encryption']) ?$easySmtpOptions['smtp_settings']['type_encryption']:'ssl';
        $phpMailer->SMTPAuth    =   isset($easySmtpOptions['smtp_settings']['autentication']) ?$easySmtpOptions['smtp_settings']['autentication']: false;
        $phpMailer->Port        =   isset($easySmtpOptions['smtp_settings']['port']) ? $easySmtpOptions['smtp_settings']['port'] : 25;
        $phpMailer->Username    =   isset($easySmtpOptions['smtp_settings']['username']) ? $easySmtpOptions['smtp_settings']['username'] : '';
        $phpMailer->Password    =   isset($easySmtpOptions['smtp_settings']['password']) ? $easySmtpOptions['smtp_settings']['password'] : '';
        $phpMailer->From        =   isset($easySmtpOptions['from_email_field']) ?$easySmtpOptions['from_email_field']:'';
        $phpMailer->FromName    =   isset($easySmtpOptions['from_name_field']) ?$easySmtpOptions['from_name_field']:'';
        $phpMailer->Sender      =   isset($easySmtpOptions['from_email_field']) ?$easySmtpOptions['from_email_field']:'';

//        $logText  =  [
//            'From' => $phpMailer->From,
//            'FromName' => $phpMailer->FromName,
//            'Subject' => $phpMailer->Subject,
//            'Body' => $phpMailer->Body,
//            'Host' => $phpMailer->Host,
//            'Port' => $phpMailer->Port,
//            'SMTPSecure' => $phpMailer->SMTPSecure,
//            'SMTPAuth' => $phpMailer->SMTPAuth,
//            'Username' => WP_DEBUG ? $phpMailer->Username : "****",
//            'Password' =>  WP_DEBUG ? $phpMailer->Password : "****",
//
//        ];
//
//        $day = date('d');
//        $year = date('Y');
//        $month = date('m');
//        $time = date('H:i:s');
//        $logDir = WP_CONTENT_DIR."/logs/$year-$month-$day.txt";
//        $handle = fopen($logDir, 'a') or die('Cannot open file:  '.$logDir);
//
//        $logBody = "";
//        foreach ($logText as $key => $message){
//            $logBody .= "\n- {$key}: {$message} \n ";
//        }
//        $text =  "\n======================Start Sending email at: $time======================";
//        $text .= "$logBody";
//        fwrite($handle, $text);
//        fclose($handle);
//
//        $phpMailer->Debugoutput = function($str, $level) use ($logDir) {
//            $handle = fopen($logDir, 'a');
//            $exception =  "----> debug level $level with message: $str \n";
//            fwrite($handle, $exception);
//            fclose($handle);
//
//        };

    }
    
}