<?php
$singlePage = new \App\Services\Post\Single();
$data = $singlePage->execute();

return [
    'view' => 'pages/partners-detail/partners-detail.twig',
    'data' => $data
];