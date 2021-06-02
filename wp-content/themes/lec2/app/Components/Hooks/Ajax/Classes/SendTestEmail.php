<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-14
 * Time: 16:33
 */

namespace App\Components\Hooks\Ajax\Classes;

use App\Components\Hooks\Ajax\AbstractAjax;
use App\Services\Helper;
use App\Services\EmailTemplates\SendTestEmail as SendMail;

/**
 * Class SendContactEmail - Send contact email
 *
 * @package App\Components\Hooks\Ajax\Classes
 */
class SendTestEmail extends AbstractAjax
{
    protected $functions = [ 'send_test_email' =>  'sendTestEmail'];

    /**
     * Create an application
     */
    public function sendTestEmail(){

        global $emailDebug;

        $sendTest = new SendMail();
        $data = Helper::stripTagArray($_POST);
        $isSent =  $sendTest->setData($data)->execute();

        wp_send_json([
            'is_sent' => $isSent,
            'message_class' => $isSent ? "updated notice notice-success" : "error",
            'message' => $isSent? 'Sent test email successfully' : "Email could not be sent",
            'debug_message' => ! $isSent ?  $emailDebug->errors : []
        ]);

    }
}