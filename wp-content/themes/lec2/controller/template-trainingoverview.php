<?php
/**
 * Template Name: Trainings Overview Page Template
 */

$singlePage = new \App\Services\Page\Single();

$data = $singlePage->execute();

return [
    'view' => 'pages/trainings-overview/trainings-overview.twig',
    'data' =>  $data
];

