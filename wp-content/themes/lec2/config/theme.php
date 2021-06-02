<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Theme Directory
    |--------------------------------------------------------------------------
    |
    | This is the absolute path to your theme directory.
    |
    | Example:
    |   /srv/www/example.com/current/web/app/themes/sage
    |
    */

    'dir' => get_template_directory(),

    'twig_parser' => get_template_directory().'/app',

    /*
    |--------------------------------------------------------------------------
    | Theme Directory URI
    |--------------------------------------------------------------------------
    |
    | This is the web server URI to your theme directory.
    |
    | Example:
    |   https://example.com/app/themes/sage
    |
    */

    'uri' => get_template_directory_uri(),


    'lang_dir'  =>  get_template_directory().'/resources/languages',
];
