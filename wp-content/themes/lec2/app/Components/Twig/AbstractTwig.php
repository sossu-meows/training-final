<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-07-25
 * Time: 03:02
 */

namespace App\Components\Twig;


use App\Container;
use Twig\Loader\FilesystemLoader;

/**
 * Class AbstractTwig
 *
 * @package App\Components\Twig
 */
class AbstractTwig
{
    protected $viewDir = '/resources/views/';

    protected $config = [];

    protected $twig = null;

    protected $data = null;

    protected $function = [];

    protected  $filters = [];

    protected  $global = [];

    /**
     * Twig constructor.
     */
    public function __construct()
    {
        $this->twigOptions();
        $this->viewDir();
        $loader  = new \Twig\Loader\FilesystemLoader($this->viewDir);
        $loader = $this->addPaths($loader);
        $this->twig = new \Twig\Environment($loader,$this->config);
        $this->parsedFunctions();
        if(count($this->function)){
            foreach ($this->function as $function){
                $this->twig->addFunction($function);
            }
        }

        $this->parsedFilter();
        if(count($this->function)){
            foreach ($this->filters as $filter){
                $this->twig->addFilter($filter);
            }
        }

        $this->parsedGlobal();
        if(count($this->function)){
            foreach ($this->global as $name => $value){
                $this->twig->addGlobal($name,$value);
            }
        }
    }

    /**
     *  We will add the namespace for twig-loader view this functions - Please refer this URL:
     *  https://stackoverflow.com/questions/28750326/twig-loader-namespacing
     *
     * @param  FilesystemLoader $loader
     * @return FilesystemLoader
     */
    public function addPaths($loader){
        return $loader;
    }

    /**
     * we can update this on the sub classes
     */
    public function viewDir(){
        $this->viewDir = Container::getInstance()->getTwigFolder();
    }

    /**
     * These functions will be pushed into twig
     */
    public function parsedFunctions(){}

    /**
     *
     * These filter will be pushed into twig
     */
    public function parsedFilter(){}

    /**
     * Global variables will be pushed into twig
     */
    public function parsedGlobal(){}

    /**
     * Render twig
     *
     * @param $name
     * @param $data
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function render($name, $data){
        return $this->twig->render($name, ['page_data' => $data]);
    }

    /**
     * Option for twig template
     *
     * @return array
     */
    public function twigOptions(){
        if(Container::getInstance()->isEnableTwigCache()){
            $this->config['cache'] = Container::getInstance()->getTwigCacheFolder();
        }
    }
}