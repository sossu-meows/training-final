<?php
/**
 * Template Name: Legal Notice Page Template
 */

$singlePage = new \App\Services\Page\Single();

$data = $singlePage->execute();

return [
    'view' => 'pages/legal-notice/legal-notice.twig',
    'data' =>  $data
];