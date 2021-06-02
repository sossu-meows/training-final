<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-07
 * Time: 11:21
 */

namespace App\Components\AcfFields\Classes;

use App\Components\AcfFields\AbstractAcfFields;
use App\Services\Helper;

/**
 * Class AcfEmployer - this is used by job's employer
 *
 * @package App\Components\AcfFields\Classes
 */
class AcfEmployer extends AbstractAcfFields
{

    /**
     * Initilize the new field type
     */
    function initialize() {

        // vars
        $this->name = 'abw_employer';
        $this->label = __("Employer",'lec2_text_domain');

    }

    /**
     * Render settings
     *
     * @param $field
     */
    public function render_field_settings($field){
        acf_render_field_setting( $field, array(
            'label'			=> __('Filter by role','acf'),
            'instructions'	=> '',
            'type'			=> 'select',
            'name'			=> 'role',
            'choices'		=> acf_get_pretty_user_roles(),
            'multiple'		=> 1,
            'ui'			=> 1,
            'allow_null'	=> 1,
            'placeholder'	=> __("All user roles",'acf'),
        ));
    }

    /**
     * Render field on edit|add page
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

        $currentUser = wp_get_current_user();

        if(Helper::isAdministrator($currentUser->roles)){
            $args = [
                'role__in' => $field['role']
            ];
            $userQuery = new \WP_User_Query( $args );
            $users = $userQuery->get_results();

            foreach( $users as $user ) {

                $field['choices'][ $user->ID ] = [
                    'value'    => $user->ID ,
                    'text' => apply_filters('user_name',$user),
                    'is_selected' => ( $user->ID == $field['value']) ? 'selected' : ''
                ];
            }

            $this->view = "employer/select";
            $this->render(['data' => $field]);
        }
        else{

            $this->view = "employer/read_only";
            $field['display_name'] = apply_filters('user_name',$currentUser);
            $field['value'] = $currentUser->ID;
            $this->render(['data' => $field]);
        }


    }

}

