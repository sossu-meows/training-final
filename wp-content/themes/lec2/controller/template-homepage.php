<?php
/**
 * Template Name: Home Page Template
 */

$singlePage         = new \App\Services\Page\Single();
$data               = $singlePage->execute();
$newFeedPosts       = $data['custom_data']['news_feed']['new_feed_posts'] ?? [];
$highLightList      =  new \App\Services\Product\ListProducts();
$videoList          = $data['custom_data']['video'] ?? [];
$trainingTypeList   = $data['custom_data']['training_types']['training_list'] ?? [];

$highLightItems =  $videoItems = [];

foreach ($highLightList->execute() as $item){
    $highLightItems[] = apply_filters("modify_post_type", $item);
}

foreach ($trainingTypeList as $key => $item){
    $data['custom_data']['training_types']['training_list'][$key]['training_type'] = apply_filters("modify_post_type", $item['training_type']);
}

if ($data['custom_data']['video']) {
    $videoItems[] = apply_filters("modify_post_type", $videoList);
}

$data['custom_data']['highlight_list']['highlight_list']    = $highLightItems;
$data['custom_data']['video']                               = $videoItems;
$data['custom_data']['home_banner']['newsletter']           = do_shortcode('[email-subscribers-form id="1"]');

return [
    'view' => 'pages/home/home.twig',
    'data' =>  $data
];

