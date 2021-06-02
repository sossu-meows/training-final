<?php
/**
 * Template Name: Trainings Overview Listing Page Template
 */

$singlePage     = new \App\Services\Page\Single();
$productCats    = new \App\Services\ProductCat\ListProductCats();
$trainings      = new \App\Services\Training\ListTrainingsAjax();
$trainingTypes  = new \App\Services\TrainingType\ListTrainingTypes();
$trainingTypeOptions = [];

$data = $singlePage->execute();

foreach( $trainingTypes->execute() as $trainingType ) {
    $trainingTypeOptions[] = array(
        "label" => $trainingType["post_title"],
        "value" => $trainingType["ID"]
    );
}

$data['custom_data']['cats'] = $productCats->execute();
array_unshift($data['custom_data']['cats'], array("label" => __("Training Topics", LEC2_DOMAIN), "value" => ""));

$data['custom_data']['trainings']       = $trainings->execute();
$data['custom_data']['training_types']  = $trainingTypeOptions;
array_unshift($data['custom_data']['training_types'], array("label" => __("Training Formats", LEC2_DOMAIN), "value" => ""));

$data['custom_data']['trainings']['path'] = '?page=';

if (isset($_GET['training_cat_id']) && $_GET['training_cat_id']) 
	$page_cat = (array) get_term($_GET['training_cat_id'], 'product_cat');
else 
	$page_cat = (array) get_term(get_option('default_product_cat'), 'product_cat');

$data['custom_data']['banner']['title'] = sprintf( __( '%s Trainings', LEC2_DOMAIN ), $page_cat['name'] );
$data['custom_data']['banner']['description'] = $page_cat['description'];

return [
    'view' => 'pages/trainings-overview-listing/trainings-overview-listing.twig',
    'data' =>  $data
];
