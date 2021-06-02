<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-07-10
 * Time: 11:00
 */

namespace App\Components\Hooks\Ajax;

use App\Components\Hooks\AbstractHook;

/**
 * Class AbstractAjax
 * @package App\Components\Hooks\Ajax
 */
abstract class AbstractAjax extends AbstractHook
{

    /**
     * Register ajax functions with this function
     *
     * @param $actionName
     * @param $function
     * @param int $priority
     * @param int $params
     */
    public function addHook($actionName, $function, $priority = 0, $params = 0)
    {
        add_action( "wp_ajax_{$actionName}", [$this, $function]);
        add_action( "wp_ajax_nopriv_{$actionName}",[$this, $function] );
    }


}