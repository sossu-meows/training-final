<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Assets Path URI
    |--------------------------------------------------------------------------
    |
    | The asset manifest contains relative paths to your assets. This URI will
    | be prepended when using Sage's asset management system. Change this if
    | you are using a CDN.
    |
    */

    'website'   => [
        'backend'   => get_template_directory_uri().'/resources/assets/website',
        'frontend'  => get_template_directory_uri().'/resources/views/frontend/dist/assets',
    ],
    'admin' => [
        'uri'   => get_template_directory_uri().'/resources/assets/admin',
        'path'  => get_template_directory().'/resources/assets/admin',
    ]
];
