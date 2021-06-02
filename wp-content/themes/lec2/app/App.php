<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-07-25
 * Time: 00:04
 */

namespace App;

use App\Components\Components;
use App\Components\Hooks\RegisterHooks;

/**
 *
 * Set up and init theme will be added here
 *
 * Class App
 * @package App
 */
class App
{
    public function init()
    {
        $component = new Components();
        $component->init();
    }

}

