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
class AcfReadOnlyText extends AbstractAcfFields
{

    protected $view = 'label';

    /**
     * Initilize the new field type
     */
    function initialize() {

        // vars
        $this->name = 'abw_read_only_text';
        $this->label = __("Read only",'lec2_text_domain');
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

        //debug($field);
        $fieldType = isset( $field['read_only_field_type']) ?  $field['read_only_field_type'] : 'label';
        $this->view = "readonly/{$fieldType}";

        if($fieldType == 'object_admin_url'){
            if(isset($field['value']) && !empty($field['value'])){
                $url    = get_edit_post_link($field['value'],'view');
                $title  = get_the_title($field['value']);

                $field['custom_value'] = [
                    'url' => $url,
                    'title' => $title,
                ];

            }

        }
        elseif ($fieldType == 'uploaded_file'){
            if(isset($field['value']) && !empty($field['value'])){
                $downloadUrl    = wp_get_attachment_url($field['value']);
                $title          = get_the_title($field['value']);
                $size           = filesize(get_attached_file($field['value'])) ;
                $sizeByteToKb   = number_format(($size / 1024),0); //kb

                $field['custom_value'] = [
                    'download_url'  =>  $downloadUrl,
                    'title'         =>  $title,
                    'size'          =>  "{$sizeByteToKb} KB"
                ];

            }

        }
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
            'label'			=> __('Field type','lec2_text_domain'),
            'type'			=> 'select',

            //please note: these array keys below map with templates in acffields/readonly/{key}.html.twig
            'choices'		=> array(
                'label'     => __("Label",'lec2_text_domain'),
                'text'		=> __("Text",'lec2_text_domain'),
                'textarea'	=> __("Text area",'lec2_text_domain'),
                'email_url'	        => __("Email URL",'lec2_text_domain'),
                'object_admin_url'	=> __("Admin editing page",'lec2_text_domain'),
                'uploaded_file'	    => __("Uploaded file URL",'lec2_text_domain'),
            ),
            'name'			=> 'read_only_field_type',
        ));

    }

}

