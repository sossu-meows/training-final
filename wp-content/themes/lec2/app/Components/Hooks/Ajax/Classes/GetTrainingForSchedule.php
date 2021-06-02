<?php


namespace App\Components\Hooks\Ajax\Classes;


use App\Components\Hooks\Ajax\AbstractAjax;
use App\Services\Training\ListTrainingsAjaxForSchedule;

class GetTrainingForSchedule extends AbstractAjax
{
    protected $functions = [ 'send_schedule_course' =>  'sendScheduleCourse'];

    public function sendScheduleCourse(){
        $trainings = new ListTrainingsAjaxForSchedule();
        if (isset($_POST["page"]))
            $trainings->setCurrentPage($_POST["page"]);
        if (isset($_POST["posts_per_page"]))
            $trainings->setPostsPerPage($_POST['posts_per_page']);

        $result = $trainings->execute();

        if($result){
            $return_data = [];

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