<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-21
 * Time: 10:28
 */

namespace App\Components\Validations\Abstracts;

/**
 * Class AbstractValidation - This is used for validating request
 * @package App\Components\Validations\Abstracts
 */
abstract class AbstractValidation
{

    /**
     * the requested data
     *
     * @var array
     */
    protected $request;

    /**
     * These registered fields will be validated
     *
     * @var array
     */
    protected $validatedFields = [];

    /**
     * Result of the validation
     *
     * @var bool
     */
    protected $result = true;

    /**
     * Return the failure key
     *
     * @var string
     */
    protected $failureKey = '';

    /**
     * Message of the validation
     *
     * @var string
     */
    protected $message = 'All values have been validated successfully';

    /**
     * @return bool
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return array
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return string
     */
    public function getFailureKey(){
        return $this->failureKey;
    }

    /**
     * @param array $request
     * @return AbstractValidation
     */
    public function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return $this
     */
    public function validate(){

        if(count($this->validatedFields) > 0){
            foreach ($this->validatedFields as $keyName => $validationFunctions){
                $data = isset($this->request[$keyName]) ? $this->request[$keyName] : null ;
                if(count($validationFunctions) > 0 ){
                    foreach ($validationFunctions as $function => $messageText){
                        $this->result = call_user_func([$this,$function], $data, $messageText);
                        if(!$this->result){
                            $this->failureKey = $keyName;
                            $this->message = __($messageText, 'lec2_text_domain');
                            return $this;
                        }
                    }
                }

            }
        }

        return $this;
    }

    /**
     * Validate required field
     *
     * @param $data
     * @return bool
     */
    public function required($data){
        if(empty($data))
        {
           return false;
        }
        return true;
    }

    /**
     * Validate valid email
     * ref: https://stackoverflow.com/questions/5855811/how-to-validate-an-email-in-php
     *
     * @param $data
     * @return bool
     */
    public function email($data){
        return is_email($data);
    }

}