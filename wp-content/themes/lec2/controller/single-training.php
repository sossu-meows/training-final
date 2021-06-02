<?php
$singlePage = new \App\Services\Post\Single();
$data = $singlePage->execute();

// get breadScrumb
$trainingOverview           = get_post(167);
$trainingOverviewPage       = apply_filters("modify_post_type", $trainingOverview);
$trainingOverviewListing    = get_post(367);
$trainingListingPage        = apply_filters("modify_post_type", $trainingOverviewListing);

$trainingCostListing = $data['custom_data']['training_type']['training_type_list'];

//get cost to add to cart
$list = [];
if(is_array($trainingCostListing) && count($trainingCostListing)){
    $_pf = new WC_Product_Factory();  
    foreach($trainingCostListing as $cost){
        $item       = $cost;
        $costObj    = $cost['training_cost'];
        if($costObj){
            $p              = $_pf->get_product($costObj->ID);
            $addToCartUrl   = $p->add_to_cart_url();
            $price          = $p->get_price_html();
            
            $item['training_cost'] = [
                'price'         => $price,
                'addToCartUrl'  => $addToCartUrl,
            ];

            $list[] = $item;
        
        }
    }
}

$trainingCostListing = $data['custom_data']['training_type']['training_type_list'] = $list;

$data['custom_data']['breadcrumb_items'] = [
    [
        'title' => $trainingOverviewPage['post_title'],
        'url'   => $trainingOverviewPage['url'],
    ],
    [
        'title' => $trainingListingPage['post_title'],
        'url'   => $trainingListingPage['url'],
    ],
    [
        'title' => $data['post_title'],
    ]
];

return [
    'view' => 'pages/trainings-overview-listing-detail/trainings-overview-listing-detail.twig',
    'data' => $data
];