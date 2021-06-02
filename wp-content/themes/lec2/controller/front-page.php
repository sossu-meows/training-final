<?php

$singlePage = new \App\Services\Page\Single();
$data = $singlePage->execute();

return [
    'view' => '/pages/home/home.twig',
    'data' =>  $data
];

