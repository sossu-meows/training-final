<?php
$singlePage                     = new \App\Services\Post\Single();
$data                           = $singlePage->execute();

return [
    'view' => 'pages/news-detail/news-detail.twig',
    'data' => $data
];