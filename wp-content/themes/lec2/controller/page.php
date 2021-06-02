<?php

$singlePage = new \App\Services\Page\Single();
$data = $singlePage->execute();

return [
    'view' => 'pages/default/default.twig',
    'data' => $data
];