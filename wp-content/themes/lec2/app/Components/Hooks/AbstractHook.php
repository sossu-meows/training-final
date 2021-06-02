<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-08
 * Time: 21:40
 */

namespace App\Components\Hooks;

/**
 * Class AbstractHook
 *
 * @package App\Components\Hooks
 */
abstract class AbstractHook
{

    /**
     * List of ajax features.
     *
     * ajax_name => ajax_function
     *
     * @var array
     */
    protected $functions = [];

    /**
     * Init all ajax feature
     *
     * @return mixed
     */
    public function init(){
        if (count($this->functions) > 0 ){
            foreach ($this->functions as $actionName => $function){
                if(is_string($function)){
                    $this->addHook($actionName,$function);
                }elseif (is_array($function)){
                    $functionName   =  $function[0];
                    $priority       =  $function[1];
                    $params         =  $function[2];
                    $this->addHook($actionName,$functionName,$priority,$params);
                }

            }
        }
    }

    /**
     * @param $actionName
     * @param $function
     * @param $priority
     * @param $params
     */
    public function addHook($actionName, $function, $priority = 0, $params = 0){
        if($priority != 0 && $params != 0){
            add_action( "{$actionName}", [$this,$function], $priority, $params);
        }else{
            add_action( "{$actionName}", [$this,$function]);
        }

    }


}