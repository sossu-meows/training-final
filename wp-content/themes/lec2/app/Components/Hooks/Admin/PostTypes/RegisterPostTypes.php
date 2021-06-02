<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-06-27
 * Time: 17:57
 */
namespace App\Components\Hooks\Admin\PostTypes;


use App\Components\ComponentInterface;
use App\Components\Hooks\Admin\PostTypes\Classes\Office;
use App\Components\Hooks\Admin\PostTypes\Classes\Partner;
use App\Components\Hooks\Admin\PostTypes\Classes\Testimonial;
use App\Components\Hooks\Admin\PostTypes\Classes\TrainingType;
use App\Components\Hooks\Admin\PostTypes\Classes\TrainingFormat;
use App\Components\Hooks\Admin\PostTypes\Classes\Video;

/**
 * Class RegisterPostTypes - After we have created the custom post types that will be registered here
 *
 * @package App\Components\PostTypes
 */
class RegisterPostTypes implements ComponentInterface
{

    protected $postTypes = [];

    /**
     * Register
     */
    public function init(){

       $this->postTypes = [
           new Partner(),
           new Testimonial(),
           new TrainingType(),
           new TrainingFormat(),
           new Video(),
       ];

       $this->initPostType();
    }

    /**
     * Init post types
     */
    protected function initPostType(){
          if(count($this->postTypes) > 0){
              foreach ($this->postTypes as $postType){
                  $postType->init();
              }
          }
    }

}
