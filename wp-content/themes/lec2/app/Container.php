<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-07-25
 * Time: 11:12
 */

namespace App;

use App\Components\AcfFields\Consts\Pages\ThemeOptions;
use App\Services\Helper;

/**
 * Class Container
 * @package App
 */
class Container
{
    // Hold the class instance.
    private static $instance = null;

    protected $config = [];

    /**
     * @return Container|null
     */
    public static function getInstance(){
        $class = get_called_class();
        if(self::$instance == null){
            self::$instance = new $class;
        }
        return self::$instance;
    }

    /**
     * @param $name
     * @param $data
     * @return $this
     */
    public function bindConfig($name, $data){
        $this->config[$name] = $data;
        return $this;
    }

    /**
     * Bind web configurations and components
     *
     *
     * @return $this
     */
    public function bindApp(){



        $app =    new App();
        $app->init();

        return $this;
    }

    /**
     * Get config
     *
     * @return array
     */
    public function getConfig(){
        return $this->config;
    }

    /**
     * Language folder
     *
     * @return mixed
     */
    public function getLangFolder(){

       return $this->config['config']['theme']['lang_dir'];
    }

    /**
     * Twig folder
     *
     * @return mixed
     */
    public function getViewsFolder(){
       return $this->config['config']['view']['paths']['views'];
    }

    /**
     * Twig folder
     *
     * @return mixed
     */
    public function getTwigFolder(){
       return $this->config['config']['view']['paths']['backend_views'];
    }

    /**
     * Frontend Twig folder
     *
     * @return mixed
     */
    public function getFrontEndTwigFolder(){
       return $this->config['config']['view']['paths']['frontend_views'];
    }

    /**
     * Asset folder
     *
     * @param string $path
     * @return mixed
     */
    public function getAssetFolder($path = 'backend'){
       return $this->config['config']['assets']['website'][$path];
    }

    /**
     * Asset folder
     *
     * @return mixed
     */
    public function getAdminAssetsFolder(){
       return $this->config['config']['assets']['admin']['uri'];
    }

    /**
     * The controller folder
     *
     * @return mixed
     */
    public function getControllerFolder(){
       return $this->config['config']['view']['paths']['parser'];
    }

    /**
     * Get theme dir
     *
     * @return mixed
     */
    public function getThemeDir(){
        return $this->config['config']['theme']['dir'];
    }

    /**
     * Twig parser
     *
     * @return mixed
     */
    public function getTwigParser(){
        return $this->config['config']['theme']['twig_parser'];
    }

    /**
     * Get theme options
     *
     * @return array|bool
     */
    public function getThemeOptions(){

        return Helper::getFields(ThemeOptions::_NAME);
    }

    /**
     * Get twig cache folder
     *
     * @return array|bool
     */
    public function getTwigCacheFolder(){
        return $this->config['config']['view']['cache']['path'];
    }

    /**
     * Twig cache is enabled
     *
     * @return mixed
     */
    public function isEnableTwigCache(){
        return $this->config['config']['view']['cache']['is_enabled'];
    }

}