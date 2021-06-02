<?php
$singlePage = new \App\Services\Job\SingleJob();
$data = $singlePage->execute();

return [
    'view' => 'pages/job-description/job-description.twig',
    'data' => $data
];