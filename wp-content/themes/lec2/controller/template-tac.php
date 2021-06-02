<?php
/**
 * Template Name: TAC Page Template
 */

$singlePage = new \App\Services\Page\Single();

$data = $singlePage->execute();

return [
    'view' => 'pages/tac/tac.twig',
    'data' =>  $data
];

