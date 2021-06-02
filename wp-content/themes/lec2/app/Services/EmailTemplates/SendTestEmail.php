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
class SendTestEmail extends AbstractEmailTemplates
{

    /**
     * @var string
     */
    protected $name  = 'send_test_email';

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
     * @return SendTestEmail
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
        $subject                = isset($this->data['subject']) ? $this->data['subject'] : '';
        $body                   = isset($this->data['message']) ? $this->data['message'] : '';
        $recipientEmail         = isset($this->data['to_email']) ? $this->data['to_email'] : '';

        $this->config['subject']        = $subject;
        $this->config['body']           = $body;
        $this->recipient                = $recipientEmail;

    }

}