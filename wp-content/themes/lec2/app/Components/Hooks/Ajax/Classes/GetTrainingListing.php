<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-14
 * Time: 16:33
 */

namespace App\Components\Hooks\Ajax\Classes;

use App\Components\Hooks\Ajax\AbstractAjax;
use App\Services\Training\ListTrainingsAjax;
/**
 * Class GetPartnerListing - Get more partner
 *
 * @package App\Components\Hooks\Ajax\Classes
 */
class GetTrainingListing extends AbstractAjax
{
    protected $functions = [ 'send_filter_course' =>  'sendFilterCourse'];

    /**
     * getMorePartner
     */
    public function sendFilterCourse(){
      $trainings = new ListTrainingsAjax();
      if (isset($_POST["page"]))
        $trainings->setCurrentPage($_POST["page"]);  
      if (isset($_POST["posts_per_page"]))
        $trainings->setPostsPerPage($_POST['posts_per_page']);
      $result = $trainings->execute();
      if($result){
        $return_data = [];

        if (isset($_GET['training_cat_id']) && $_GET['training_cat_id']) {
          $return_data['category'] = (array) get_term($_GET['training_cat_id'], 'product_cat');
        } elseif (isset($_POST['training_cat_id']) && $_POST['training_cat_id']) {
          $return_data['category'] = (array) get_term($_POST['training_cat_id'], 'product_cat');
        } else {
          $return_data['category'] = (array) get_term(get_option('default_product_cat'), 'product_cat');
        }

        $return_data['trainings'] = $result;
        $return_data['trainings']['message'] = 'No results match your search criteria.';
        $return_data['category']['name'] = sprintf( __( '%s Trainings', 'lec2_text_domain' ), $return_data['category']['name'] );

        wp_send_json($return_data);
      } else{
        wp_send_json(array(
          'status' =>  false
        ));
      }
    }
}