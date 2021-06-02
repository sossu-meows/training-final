<?php
/**
 * Template Name: Contact Us Page Template
 */

$singlePage = new \App\Services\Page\Single();
$data = $singlePage->execute();

return [
    'view' => 'pages/contact/contact.twig',
    'data' =>  $data
];

