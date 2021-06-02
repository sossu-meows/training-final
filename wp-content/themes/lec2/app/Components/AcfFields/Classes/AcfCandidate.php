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

/**
 * Class AcfCandidate
 * @package App\Components\AcfFields\Classes
 */
class AcfCandidate extends AbstractAcfFields
{

    protected $view = 'candidates';

    /**
     * Initilize the new field type
     */
    function initialize() {

        // vars
        $this->name = 'abw_candidates';
        $this->label = __("Candidates",'lec2_text_domain');
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

        $idListing              = isset($field['value'])  ? $field['value']: [];
        if(empty($idListing)){
            $idListing = [];
        }

        $listApplicationService = new ListApplicationsAjax();
        $applications           =    $listApplicationService->setIdListing($idListing)->execute();
        $this->render(['applications' => $applications,'query' => implode(',',$idListing)]);

    }

}

