<?php
/**
 * Template Name: Partner Page Template
 */

$singlePage     = new \App\Services\Page\Single();
$partners       = new \App\Services\Partner\ListPartners();
$testimonials   = new \App\Services\Testimonial\ListTestimonials();

$data = $singlePage->execute();
$data['custom_data']['partners_section']['partner_list']    = $partners->execute();
$data['custom_data']['testimonials']['testimonials']        = $testimonials->execute();

    return [
    'view' => 'pages/partners/partners.twig',
    'data' =>  $data
];

