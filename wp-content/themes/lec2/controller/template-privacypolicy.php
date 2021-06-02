<?php
/**
 * Template Name: Privacy Policy Page Template
 */

$singlePage = new \App\Services\Page\Single();

$data = $singlePage->execute();

return [
    'view' => 'pages/privacy-policy/privacy-policy.twig',
    'data' =>  $data
];

