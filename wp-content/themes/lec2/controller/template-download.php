<?php
/**
 * Template Name: Payment Template
 */

$singlePage = new \App\Services\Page\Single();
$data = $singlePage->execute();

return [
    'view' => '/pages/payment/payment.twig',
    'data' =>  $data
];

