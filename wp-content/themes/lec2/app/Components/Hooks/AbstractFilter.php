<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-08
 * Time: 21:49
 */
namespace App\Components\Hooks;

/**
 * Add filter
 *
 * Class AbstractFilter
 * @package App\Components\Hooks
 */
abstract class AbstractFilter extends AbstractHook
{

    /**
     * @param $actionName
     * @param $function
     * @param int $priority
     * @param int $params
     */
    public function addHook($actionName, $function, $priority = 0, $params = 0)
    {
        if($priority != 0 && $params != 0){
            add_filter( "{$actionName}", [$this,$function], $priority, $params);
        }else{
            add_filter( "{$actionName}", [$this,$function]);
        }
    }

}