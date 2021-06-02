<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-06-27
 * Time: 18:39
 */
namespace App\Components\ShortCodes;

use App\Components\ComponentInterface;

/**
 * Class AbstractShortCode
 *
 * @package App\Components\ShortCodes
 */
abstract class AbstractShortCode implements ComponentInterface
{
    protected $name;

    public function init()
    {
        add_shortcode($this->name,function($att){
            return $this->shortCodeContent($att);
        });
    }

    abstract public function shortCodeContent($att);
}

