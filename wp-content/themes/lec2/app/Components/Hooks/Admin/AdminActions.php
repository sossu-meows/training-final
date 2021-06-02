<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-08
 * Time: 22:03
 */
namespace App\Components\Hooks\Admin;


use App\App;
use App\Components\AcfFields\Consts\PostTypes\User;
use App\Components\Hooks\AbstractHook;
use App\Components\AcfFields\Consts\PostTypes\Office;
use App\Components\Sidebars\Widgets\Classes\DefaultWidget;
use App\Container;
use App\Services\Helper;

/**
 * Class AdminActions - Hook for admin panel
 *
 * @package App\Components\Hooks\Website
 */
class AdminActions extends AbstractHook
{

    protected  $functions = [
        'admin_enqueue_scripts'     => 'adminEnqueueScripts',
        'user_register'             => ['addedUser',10,1],
        'profile_update'            => ['saveUser',10,2],
        'widgets_init'              => 'initWidget',
        'admin_head'                => 'faviconForAdmin',
        'login_head'                => 'faviconForAdmin',
        'show_user_profile'         => 'userOffice',
        'edit_user_profile'         => 'userOffice',
    ];

    /**
     * Register script for admin
     */
    public function adminEnqueueScripts(){
        $assetFolder = Container::getInstance()->getAdminAssetsFolder();
        wp_enqueue_style('admin/custom.css', "{$assetFolder}/styles/main.css", false, null);
        wp_enqueue_script('admin/custom.js', "{$assetFolder}/scripts/main.js", ['jquery'], null, true);
    }

    /**
     * Added a user into DB
     *
     * @param $userId
     * @param $oldProfile
     */
    public function saveUser($userId, $oldProfile){

        $this->setModeratorForOffice($userId,$_POST);
    }

    /**
     * Update a user profile
     *
     * @param $userId
     */
    public function addedUser($userId){
        $this->setModeratorForOffice($userId,$_POST);
    }

    /**
     * Add this moderator to the selected office
     *
     * @param $userID
     * @param $data
     */
    public function setModeratorForOffice($userID, $data){
        $acfFields = isset($data['acf'])?$data['acf']:[];
        if(count($acfFields) > 0){
            foreach ($acfFields as $acfField){

                $postType =  get_post_type($acfField);
                //check: if the ACF value is belong ot office, if it is an office, it will be added the updated /inserted moderator
                if($postType == Office::_NAME){

                    $moderator = get_field(Office::_MODERATORS, $acfField);

                    if(empty($moderator)){
                        $moderator = [$userID];
                    }else{
                        $moderator = array_merge($moderator,[$userID]);
                    }

                    update_field(Office::_MODERATORS, $moderator, $acfField);

                }
            }
        }

    }

    /**
     * Register wiget
     */
    public function initWidget(){
        register_widget(DefaultWidget::class);
    }

    /**
     *  favicon for admin panel
     */
    public function faviconForAdmin(){
        $themeOptions = Container::getInstance()->getThemeOptions();
        $icon = isset($themeOptions['website']['favicon'])?$themeOptions['website']['favicon']:'';
        if($icon){
            echo "<link rel='shortcut icon' type='image/x-icon' href='{$icon}' />";
        }
    }

    /**
     * @param $user
     *
     * Office of a user, if the logged-in user is not administrator he can't update his office.
     */
    public function userOffice($user){
        $currentUser = wp_get_current_user();
        if($currentUser){
            $roles = $currentUser->roles;

            if(!Helper::isAdministrator($roles)){
                $office = get_field(User::_OFFICE, $user);
                $officeTitle = is_object($office)?$office->post_title:'';
                $text = __('Office','lec2_text_domain');

                echo "<table class='form-table'>
                    <tbody>
                        <tr>
                            <th class='user-description-wrap'>{$text}</th>
                            <td>$officeTitle</td>
                        </tr>   
                    </tbody>
              </table>";
            }

        }

    }

}