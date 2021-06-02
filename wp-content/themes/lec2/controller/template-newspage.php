<?php
/**
 * Template Name: News Page Template
 */

    use App\Services\Post\ListPostAjax;
    $singlePage     = new \App\Services\Page\Single();
    $highLightList  = new \App\Services\Product\ListProducts();

    $data           = $singlePage->execute();
    $highLightItems = [];
    foreach ($highLightList->execute() as $item){
        $highLightItems[] = apply_filters("modify_post_type", $item);
    }
    $data['custom_data']['highlight_list']['highlight_list']    = $highLightItems;

return [
    'view' => 'pages/news/news.twig',
    'data' =>  $data
];