<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-07-25
 * Time: 00:41
 */

namespace App;


use App\Components\Twig\FrontEndTwig;
use App\Components\Twig\Twig;

/**
 * Class TwigLoader - Factory method is applied into this class: i don't want to call Twig class many times in this projects
 * @package App
 */
class TwigLoader
{

    /**
     * @param $view
     * @param $data
     * @param bool $isBackend
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public static function load($view, $data, $isBackend = true){

        $twig = null;
        if ($isBackend) {
            $twig = new Twig();
        }
        else {
            $twig = new FrontEndTwig();
        }

        return $twig->render($view,$data);
    }

    /**
     * @param $view
     * @param array $data
     * @param bool $isBackend
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public static function render($view, $data = [], $isBackend = true) {
        if (isset($_GET['dump']) && WP_DEBUG) {
            echo self::load('/commons/debugger.html.twig',$data);
        }

        echo self::load($view, $data, $isBackend);
    }
}