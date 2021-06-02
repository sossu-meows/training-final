<?php


    namespace App\Services\Product;


    use App\Services\AbstractListingObjects;

    class ListProducts extends AbstractListingObjects
    {
        protected  $query = [
            'post_type'         => 'product',
            'posts_per_page'    => 4,
            'orderby'           => 'date',
            'order'             => 'desc',
            'post_status'       => 'publish'
        ];
    }