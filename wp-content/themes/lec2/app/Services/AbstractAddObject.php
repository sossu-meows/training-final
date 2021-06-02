<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-02
 * Time: 16:09
 */

namespace App\Services;

/**
 * Class AddObject
 * @package App\Services
 */
abstract class AbstractAddObject extends AbstractSingleObject
{
    protected  $postAttr;

    protected $data;

    /**
     * @param $data
     * @return $this
     */
    public function setData($data){
        $this->data = $data;
        return $this;
    }

    /**
     * @return array|int|\WP_Error|\WP_Query|null
     */
    public function execute()
    {
        return wp_insert_post( $this->postAttr );
    }

    /**
     * @return mixed
     */
    public function beforeExecute(){
        return $this->postAttr;
    }
}