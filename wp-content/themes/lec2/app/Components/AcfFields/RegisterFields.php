<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-07
 * Time: 11:14
 */

namespace App\Components\AcfFields;


use App\Components\AcfFields\Classes\AcfCandidate;
use App\Components\AcfFields\Classes\AcfEmployer;
use App\Components\AcfFields\Classes\AcfJobLabel;
use App\Components\AcfFields\Classes\AcfReadOnlyText;
use App\Components\AcfFields\Classes\AcfRecruiters;
use App\Components\AcfFields\Classes\AcfSendTestMessage;
use App\Components\ComponentInterface;

/**
 * We use this class for registering ACF fields. Basically, we can see these registered fields on add/edit a field group on admin panel.
 *
 * Class RegisterFields
 * @package App\Components\AcfFields
 */
class RegisterFields implements ComponentInterface
{

    protected $classes = [
        AcfCandidate::class,
        AcfReadOnlyText::class,
        AcfEmployer::class,
        AcfRecruiters::class,
        AcfJobLabel::class,
        AcfSendTestMessage::class,
    ];

    /**
     * Register those classes above
     */
    public function init()
    {
        foreach ($this->classes as $class){
            if(function_exists('acf_register_field_type')){
                acf_register_field_type($class);
            }
        }

    }
}