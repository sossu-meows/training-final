<?php

/**
 * Template Name: Checkout Page Template
 */

$singlePage = new \App\Services\Page\Single();
$data = $singlePage->execute();
//debug($data, true);
return [
    'view' => '/pages/checkout/checkout.twig',
    'data' => $data
];
