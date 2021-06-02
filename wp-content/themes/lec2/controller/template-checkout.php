<?php
/**
 * Template Name: Checkout Page Template
 */

$singlePage = new \App\Services\Page\Single();
$data = $singlePage->execute();

return [
    'view' => '/pages/checkout/checkout.twig',
    'data' => $data
];
