<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-07
 * Time: 11:21
 */

namespace App\Components\AcfFields\Classes;

use App\Components\AcfFields\AbstractAcfFields;

/**
 * Class AcfLabel
 *
 * @package App\Components\AcfFields\Classes
 */
class AcfSendTestMessage extends AbstractAcfFields
{

    protected $view = 'sendtest/send_test_email';

    /**
     * Initilize the new field type
     */
    function initialize() {

        // vars
        $this->name = 'acf_send_test_message';
        $this->label = __("Send Test Message",'sa_text_domain');
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
        $this->render(['data' => $field]);
    }

    /**
     * Render field settings
     *
     * @param $field
     */
    function render_field_settings( $field ) {
        // maxlength
        acf_render_field_setting( $field, array(
            'label'			=> __('Send Test email','sa_text_domain'),
            'name'			=> __('send_test_email','sa_text_domain'),
            'to_email_default' => __('Default to email','sa_text_domain')
        ));

    }

}

