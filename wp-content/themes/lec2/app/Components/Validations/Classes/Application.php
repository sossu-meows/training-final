<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-21
 * Time: 11:42
 */

namespace App\Components\Validations\Classes;


use App\Components\Validations\Abstracts\AbstractValidation;

/**
 * Validated create an application
 *
 * Class Application
 * @package app\Components\Validations\Classes
 */
class Application extends AbstractValidation
{

    /**
     * @var $_FILES
     */
    protected $uploadedFile;

    /**
     * @var \WP_Post
     */
    protected $post;

    public function getPost(){
        return $this->post;
    }

    /**
     * @param $file
     * @return $this
     */
    public function setUploadedFile($file){
        $this->uploadedFile = $file;
        return $this;
    }

    /**
     * Validate these fields below
     *
     * @var array
     */
    protected $validatedFields = [
        'full_name'     =>  ['required'  => 'Please insert full name'],
        'email'         =>  ['required' => 'Please insert email address','email'        => 'Please insert a valid email address'],
        'phone'         =>  ['required' => 'Please insert phone'],
        'job_id'        =>  ['required' => 'Please insert job ID', 'hasPublishPost'     => 'The inserted Jb_id does not have published post'],
        'attachment'    =>  ['fileRequired' => 'Please insert attachment', 'fileType'   => 'Please upload the valid file types ( \'pdf\', \'doc\', \'docx\', \'png\', \'jpeg\')'],
    ];

    /**
     * Validate required uploaded file
     *
     * @param null $file
     * @return bool
     */
    public function fileRequired($file = null){
       if(empty($this->uploadedFile)){
           return false;
       }
       return true;
    }

    /**
     * Validate valid file type
     *
     * @param null $file
     * @return bool
     */
    public function fileType($file = null){
        $validTypes = [
            'pdf', 'doc', 'docx', 'png', 'jpeg'
        ];

        $uploadedType = isset($this->uploadedFile['type'])?$this->uploadedFile['type']:'';
        if(empty($uploadedType)){
            return false;
        }

        $check = false;
        foreach ($validTypes as $type){

            if (strpos($uploadedType, $type) !== false){
                $check = true;
            }
        }

        return $check;

    }

    /**
     * Validate the inserted Job_id has published post
     *
     * @param $data
     * @return bool
     */
    public function hasPublishPost($data){

        $this->post = get_post($data);
        if(! $this->post){
            return false;
        }

        if( $this->post->post_status != 'publish'){
            return false;
        }

        return true;
    }
}