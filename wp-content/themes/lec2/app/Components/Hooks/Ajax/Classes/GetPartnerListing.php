<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-14
 * Time: 16:33
 */

namespace App\Components\Hooks\Ajax\Classes;

use App\Components\Hooks\Ajax\AbstractAjax;
use App\Services\Partner\ListPartnersAjax;
/**
 * Class GetPartnerListing - Get more partner
 *
 * @package App\Components\Hooks\Ajax\Classes
 */
class GetPartnerListing extends AbstractAjax
{
    protected $functions = [ 'get_more_partner' =>  'getMorePartner'];

    /**
     * getMorePartner
     */
    public function getMorePartner(){
      $getPartnerListing = new ListPartnersAjax();
      $getPartnerListing->setCurrentPage($_POST['pageNumber']);     
      $getPartnerListing->setPostsPerPage($_POST['postsPerPage']);
      $result = $getPartnerListing->execute();
      if($result){
        wp_send_json($result);
      } else{
        wp_send_json(array(
          'status' =>  false
        ));
      }
    }
}