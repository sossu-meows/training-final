<?php
/**
 * Template Name: About Us Page Template
 */

$singlePage = new \App\Services\Page\Single();
$data = $singlePage->execute();

$testimonials = new \App\Services\Testimonial\ListTestimonials();

$data = $singlePage->execute();
$data['custom_data']['testimonials']['testimonials'] = $testimonials->execute();

return [
    'view' => 'pages/about/about.twig',
    'data' =>  $data
];

