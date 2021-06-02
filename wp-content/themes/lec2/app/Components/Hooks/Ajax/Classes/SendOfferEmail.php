<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-14
 * Time: 16:33
 */

namespace App\Components\Hooks\Ajax\Classes;

use App\Components\Hooks\Ajax\AbstractAjax;
use App\Components\Validations\Classes\Contact;
use App\Components\Validations\Classes\Offer;
use App\Services\Helper;
use App\Services\EmailTemplates\SendOfferEmail as SendMail;

/**
 * Class SendOfferEmail - Send offer email
 *
 * @package App\Components\Hooks\Ajax\Classes
 */
class SendOfferEmail extends AbstractAjax
{
    protected $functions = [ 'send_offer_email' =>  'sendOfferEmail'];

    /**
     * Create an application
     */
    public function sendOfferEmail()
    {

        global $emailDebug;

        $validation = new Offer();
        $sendOffer  = new SendMail();
        $data       = Helper::stripTagArray($_POST);
        $result     = $validation->setRequest($data)->validate();

        if ($result->getRequest()) {
            $isSent = $sendOffer->setData($data)->execute();

            if ($isSent) {
                wp_send_json(array(
                    'status' => true,
                    'message' => __('Your contact email was sent successfully', 'lec2_text_domain'),
                    'message_class' => $isSent ? "updated notice notice-success" : "error",
                    'debug_message' => !$isSent ? $emailDebug->errors : [],
                ));
            }
            else {
                wp_send_json(array(
                    'status' => false,
                    'message' => __('Your contact email could not be sent', 'lec2_text_domain')
                ));
            }
        } else {

            wp_send_json([
                'status'            => $result->getResult(),
                'failure_key'       => $result->getFailureKey(),
                'message'           => __($result->getMessage(),'lec2_text_domain')
            ]);
        }
    }
}