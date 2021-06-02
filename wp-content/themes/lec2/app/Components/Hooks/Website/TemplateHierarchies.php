<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-08
 * Time: 22:27
 */

namespace App\Components\Hooks\Website;

use App\Container;

/**
 * Move template files into sub-folder
 *
 * Class TemplateHierarchies
 * @package App\Components\Hooks\Website
 */
class TemplateHierarchies extends Filters
{

    /**
     * Move templates into sub folder
    */
    protected  $list = [
         'index',
         '404',
         'archive',
         'author',
         'category',
         'tag',
         'taxonomy',
         'date',
         'home',
         'page',
         'paged',
         'search',
         'single',
         'singular',
         'attachment',
         'embed',
         //'frontpage' // if we use the option "Reading Settings -> Your homepage displays -> A static page (select below)", we won't enable this. Because it will override out home-page template.
    ];

    protected $functions = [
        'template_hierarchy' => 'moveTemplateTo'
    ];


    /**
     * Move templates into sub folder
     *
     * @param $templates
     * @return mixed
     */
   public function moveTemplateTo($templates){
       $controllerFolder = Container::getInstance()->getControllerFolder();
       foreach ($templates as $k => $template){
           // wordpress will understand the path of template page if it lives in sub folder, but the default pages is always in theme root.
           if(strpos($template,$controllerFolder) === false){
               $templates[$k] = "{$controllerFolder}/{$template}";
           }
       }
       return $templates;
   }

    /**
     * Override parent's function
     *
     * @return mixed|void
     */
    public function init(){
        if (count($this->functions) > 0 ){
            foreach ($this->list as $templateName){
                foreach ($this->functions as $actionName => $function){
                    $this->addHook("{$templateName}_{$actionName}",$function);
                }
            }

        }
    }
}