<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-15
 * Time: 14:35
 */

namespace App\Components\Twig;

use App\Container;

/**
 * Class FrontEndTwig - override parent's method via this class.
 * This function help us read view templates from front-end folder.
 * And add namespace into twig-loader
 *
 * @package App\Components\Twig
 */
class FrontEndTwig extends Twig
{

    /**
     * Read front-end folder
     */
    public function viewDir()
    {
        $this->viewDir = Container::getInstance()->getFrontEndTwigFolder();
    }

    /**
     * Add namespace for frontend. Please refer this https://stackoverflow.com/questions/28750326/twig-loader-namespacing
     *
     * @param \Twig\Loader\FilesystemLoader $loader
     * @return \Twig\Loader\FilesystemLoader
     * @throws \Twig\Error\LoaderError
     */
    public function addPaths($loader)
    {
        $views = $this->viewDir;
        $loader->addPath($views, 'views');
        return $loader;
    }
}