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
 * Class SendRequestForm - Request email
 * @package App\Services\EmailTemplates
 */
class SendRequestForm extends AbstractEmailTemplates
{

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
     * @return SendRequestForm
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * These tags below will be replaced by text
     *
     * @var array
     */
    protected $tags  = [
        'headers'    => [
            '{firstname}'           => 'firstname',
            '{lastname}'            => 'lastname'
        ],
        'subject'    => [
            '{firstname}'           => 'firstname'
        ],
        'body'       => [
            '{firstname}'           => 'firstname',
            '{lastname}'            => 'lastname',
            '{phone}'               => 'phone',
            '{message}'             => 'message'
        ]
    ];

    /**
     * Create a boy for email
     */
    public function createConfigurationBody()
    {
        $themeOptions = $this->themeOptions;

        $headerFrom             = "";
        $subject                = $this->subject();
        $body                   = $this->renderEmail();
        $recipientEmail         = $themeOptions[ThemeOptions::_CONTACT_RECIPIENT_EMAIL] ?? '';
        //send for external emails which will come from contact form
        if(isset($this->data['to_email']) && $this->data['to_email'] != ''){
            $recipientEmail = $this->data['to_email'];
        }

        $this->config['headers'][]      = "From: {$headerFrom}";
        $this->config['subject']        = $subject;
        $this->config['body']           = $body;
        $this->recipient                = $recipientEmail;

    }

    public function renderEmail(){
        $emailContent = '<table bgcolor="'.GetBaseSettingEmail::getBackGroundColor().'" style="font-family:Helvetica,san-serif;color:'.GetBaseSettingEmail::getBodyTextColor().'" width="100%">
  <tbody>
    <tr>
      <td style="padding:0 20px">
        <table align="center" bgcolor="'.GetBaseSettingEmail::getBodyBackGroundColor().'" cellpadding="0" cellspacing="0" style="margin-top:20px;margin-bottom:20px;border-radius:7px;width:100%;max-width:550px">
          <tbody>
            <tr bgcolor="'.GetBaseSettingEmail::getBaseColor().'" height="100">
              <td style="padding:20px 30px;border-radius:7px 7px 0 0"> <a href="" target="_blank"> <img title="lec2-logo" alt="logo" border="0" width="39px" height="60px" style="float:left; display: block;" src="'. GetBaseSettingEmail::getHeaderImage().'" class="logo"> </a> </td>
            </tr>
            <tr>
              <td style="padding:10px"> <b>From:</b> '.$this->fullName().' </td>
            </tr>
            <tr>
              <td style="padding:10px"> <b>Subject:</b> '.$this->subject().' </td>
            </tr>
            <tr>
              <td style="padding:10px"><b>Message:</b> '.$this->message().' </td>
            </tr>
            <tr>
              <td style="padding:10px"> <b>Phone:</b> '.$this->phone().' </td>
            </tr>
            <tr>
              <td style="padding:10px"> <b>Email:</b> '.$this->email().' </td>
            </tr>
            <tr>
              <td style="padding:20px 10px;font-size:13px;color:#5c5c5c;text-align:center"> '.GetBaseSettingEmail::getFooter().' </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>';
        return $emailContent;
    }

    public function subject(){
        return "Request Form";
    }

    /**
     * Replace full name tag
     *
     * @return mixed|string
     */
    public function fullName(){
        return (isset($this->data['firstname']) ? $this->data['firstname'] : '')." ".(isset($this->data['lastname']) ? $this->data['lastname'] : '');
    }

    /**
     * Replace phone tag
     *
     * @return mixed|string
     */
    public function phone(){
        return isset($this->data['phone']) ? $this->data['phone'] : '';
    }

    /**
     * Replace description tag
     *
     * @return mixed|string
     */
    public function message(){
        return isset($this->data['message']) ? $this->data['message'] : '';
    }

    /**
     * Replace description tag
     *
     * @return mixed|string
     */
    public function email(){
        return isset($this->data['email']) ? $this->data['email'] : '';
    }
}