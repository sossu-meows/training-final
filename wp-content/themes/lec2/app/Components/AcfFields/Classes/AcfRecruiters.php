<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-16
 * Time: 15:27
 */

namespace App\Components\AcfFields\Classes;


use App\Components\AcfFields\AbstractAcfFields;
use App\Components\AcfFields\Consts\PostTypes\User;
use App\Services\Application\ListApplicationsAjax;

/**
 * Class AcfRecruiters - Load all recruiter for office with ajax
 * @package App\Components\AcfFields\Classes
 */
class AcfRecruiters extends AbstractAcfFields
{

    protected $view = 'employer/list';

    /**
     * Initilize the new field type
     */
    function initialize() {

        // vars
        $this->name = 'abw_recruiters';
        $this->label = __("Employers",'lec2_text_domain');
        $this->defaults = array(
            'default_value'	=> '',
            'maxlength'		=> '',
            'placeholder'	=> '',
            'prepend'		=> '',
            'append'		=> ''
        );

    }



    /**
     * Render field on edit|add page - Logic is load all users who have been assigned office by admin
     *
     * @param $field
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    function render_field( $field ) {

        $args = array(
            'meta_key'      => User::_OFFICE,
            'meta_value'    => get_the_ID(),
            'meta_compare'  => '=',
            'orderby' => 'user_nicename',
            'order' => 'ASC',
        );

        $userQuery = new \WP_User_Query( $args );
        $users = $userQuery->get_results();
        $this->render(['users' => $users]);
    }

}