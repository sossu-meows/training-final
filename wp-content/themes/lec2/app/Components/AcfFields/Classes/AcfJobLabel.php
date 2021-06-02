<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-07
 * Time: 11:21
 */

namespace App\Components\AcfFields\Classes;

use App\Components\AcfFields\AbstractAcfFields;
use App\Services\Application\ListApplicationsAjax;
use App\Services\Helper;

/**
 * Class AcfCandidate
 * @package App\Components\AcfFields\Classes
 */
class AcfJobLabel extends AbstractAcfFields
{

    protected $view = 'readonly/label';

    /**
     * Initilize the new field type
     */
    function initialize() {

        // vars
        $this->name = 'abw_job_label';
        $this->label = __("Job label",'lec2_text_domain');
        $this->defaults = array(
            'default_value'	=> '',
            'maxlength'		=> '',
            'placeholder'	=> '',
            'prepend'		=> '',
            'append'		=> ''
        );

    }

    /**
     * @param $field
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    function render_field( $field ) {

        $label = Helper::jobLabel(get_post());
        $this->render(['data' => ['value' => $label['text']]]);

    }

}

