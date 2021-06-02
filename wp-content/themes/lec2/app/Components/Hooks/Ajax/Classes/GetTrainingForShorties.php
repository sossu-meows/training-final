<?php


namespace App\Components\Hooks\Ajax\Classes;


use App\Components\Hooks\Ajax\AbstractAjax;
use App\Services\Training\ListTrainingsAjax;

class GetTrainingForShorties extends AbstractAjax
{
    protected $functions = [ 'send_shorties_course' =>  'sendShortiesCourse'];

    public function sendShortiesCourse(){
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

            $return_data['items'] = $result;
            $return_data['items']['message'] = 'No results match your search criteria.';

            foreach ($return_data['items']['data'] as $key => $item) {

                $return_data['items']['data'][$key] = [
                    'post_title'        => $item['post_title'],
                    'infor_url'         => $item['url'],
                ];
            }

            wp_send_json($return_data);
        } else{
            wp_send_json(array(
                'status'    => false,
            ));
        }
    }
}