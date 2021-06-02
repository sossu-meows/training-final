<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-08
 * Time: 14:48
 */

namespace App\Services;


/**
 * These statics functions will be used in the whole project.
 *
 * Class Helper
 * @package App\Services
 */
class Helper
{
    /**
     * Return a job's label the logic of this field is described
     * "If Job Offer was published less than 7 days ago then ‘New’ label should be
     *  displayed. Otherwise, label is hidden."
     *
     * @param \WP_Post $job
     * @return  array
     */
    public static function jobLabel($job){
        if(!is_object($job)){
            $job = get_post($job);
        }

        $comparedDays   = 7;
        $publishedDate  = $job->post_date_gmt;
        $now            = time();
        $diff           =  ( ( $now - strtotime($publishedDate)) / 86400 ) ;
        $label          = '';
        $isShowLabel    = false;
        if($diff <= $comparedDays){
            $label          = __('New','lec2_text_domain');
            $isShowLabel    = true;
        }
        return [
            'compare_days'              => $comparedDays,
            'published_date'            => $publishedDate,
            'current_date'              => date(get_option( 'date_format' ) , $now),
            'text'                      => $label,
            'is_show_label'             => $isShowLabel,
            'days_diff'                 => $diff,
        ];
    }

    /**
     * Check the inserted roles, are they a administrator.
     *
     * @param $roles
     * @return bool
     */
    public static function isAdministrator($roles){
        $allowedRoles = ['administrator','twig_administrator'];
        if(!count(array_intersect($allowedRoles, $roles))){
            return false;
        }
        return true;
    }

    /**
     * get table's prefix
     *
     * @return string
     */
    public static function getTablePrefix(){
        global $wpdb;
        return $wpdb->prefix;
    }

    /**
     * Get wordpress pagination
     *
     * @return array|string|void
     */
    public static function pagination(){
        $pagination = paginate_links();
        wp_reset_query();
        return $pagination;
    }

    /**
     * Factoring get_fields function
     *
     * @param null $id
     * @return array|bool
     */
    public static function getFields($id = null){
        if(function_exists('get_fields')){
            return get_fields($id);
        }
        return '';
    }

    /**
     * Strip tags the inserted array
     *
     * @param $data
     * @return array
     */
    public static function stripTagArray($data){
        if (is_array($data) && count($data) > 0){
            foreach ($data as $k => $item){
                $data[$k] = strip_tags($item);
            }
        }
        return $data;
    }

}