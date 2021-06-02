<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-14
 * Time: 16:33
 */

namespace App\Components\Hooks\Ajax\Classes;

use App\Components\Hooks\Ajax\AbstractAjax;
use App\Components\Validations\Classes\RequestFormContact;
use App\Services\EmailTemplates\SendRequestForm;
use App\Services\Helper;

/**
 * Class SendRequestEmail - Send contact email
 *
 * @package App\Components\Hooks\Ajax\Classes
 */
class sendRequestEmail extends AbstractAjax
{
    protected $functions = [ 'send_request_email' =>  'sendRequestEmail'];

    /**
     * Create an application
     */
    public function sendRequestEmail(){
        $sendRequestEmail   = new SendRequestForm();
        $validation         = new RequestFormContact();
        $data               = Helper::stripTagArray($_POST);
        $result             = $validation->setRequest($data)->validate();

        if ($result->getResult()) {
            $sendRequestEmail->setData($data)->execute();
        } else {
            wp_send_json(array(
                'status'            => $result->getResult(),
                'failure_key'       => $result->getFailureKey(),
                'message'           => __($result->getMessage(),'lec2_text_domain')
            ));
        }
    }
}