<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-14
 * Time: 16:31
 */

namespace App\Services\EmailTemplates;


use App\Components\AcfFields\Consts\Pages\ThemeOptions;

/**
 * Class ContactForm - Contact email
 * @package App\Services\EmailTemplates
 */
class SendOfferEmail extends AbstractEmailTemplates
{

    /**
     * @var string
     */
    protected $name  = 'send_offer_email';

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return SendOfferEmail
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }


    /**
     * Create a boy for email
     */
    public function createConfigurationBody()
    {
        $subject                = "Offer email";
        $body                   = "Offer email body";
        $recipientEmail         = isset($this->data['to_email']) ? $this->data['to_email'] : '';

        $this->config['subject']        = $subject;
        $this->config['body']           = $body;
        $this->recipient                = $recipientEmail;

    }

}