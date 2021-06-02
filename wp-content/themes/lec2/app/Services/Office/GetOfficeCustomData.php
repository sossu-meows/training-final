<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-07-25
 * Time: 17:39
 */

namespace App\Services\Office;


use App\Services\AbstractSingleObject;

/**
 * Class get office custom data - Single office
 * @package App\Services\Post
 */
class GetOfficeCustomData extends AbstractSingleObject
{
    protected $office;

    /**
     * @return mixed
     */
    public function getOffice()
    {
        return $this->office;
    }

    /**
     * @param mixed $office
     * @return GetOfficeCustomData
     */
    public function setOffice($office)
    {
        $this->office = $office;
        return $this;
    }

    /**
     * @return array|\WP_Query|null
     */
    public function execute()
    {
        $returnData = $this->parseData($this->office);
        if($returnData){
            return $returnData;

        }
        return null;
    }

}