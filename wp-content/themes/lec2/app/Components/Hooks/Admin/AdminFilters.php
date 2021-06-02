<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-08
 * Time: 21:51
 */

namespace App\Components\Hooks\Admin;

use App\Components\Hooks\AbstractFilter;


/**
 * Register Admin filter here
 *
 * Class Filters
 * @package App\Components\Hooks\Website
 */
class AdminFilters extends AbstractFilter
{

    protected $functions = [
        'acf/prepare_field'         => ['acfPrepareField',PHP_INT_MAX,1],
        'acf/get_field_groups'      => ['acfTranslateBoxes',PHP_INT_MAX,1],
    ];

    /**
     * Translate ACF field's title
     *
     * @param $field
     * @return mixed
     */
    public function acfPrepareField($field){
       $field['label'] = __($field['label'],'lec2_text_domain');
       if($field['type'] == 'repeater'){
           $field['button_label'] = __($field['button_label'],'lec2_text_domain');
       }


       if(strpos($field['name'],'acf_field_group') === false){
           if(isset($field['choices']) && count($field['choices']) > 0){
               foreach ($field['choices'] as $k => $item){
                   $field['choices'][$k] = __($item,'lec2_text_domain');
               }
           }
       }

       return $field;
    }

    /**
     * Translate title of meta-boxes
     *
     * @param $fieldGroups
     * @return array
     */
    public function acfTranslateBoxes($fieldGroups){

        if (is_array($fieldGroups) && count($fieldGroups) > 0){
            foreach ($fieldGroups as $key => $fieldGroup){
                //$fieldGroups[$key]['title'] =  __($fieldGroup['title'],'lec2_text_domain');
            }
        }

        return $fieldGroups;
    }
}