<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most template systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views.
    |
    */

    'paths' => [
        'views'              =>      get_template_directory().'/resources/views',
        'backend_views'      =>      get_template_directory().'/resources/views/backend',
        'frontend_views'     =>      get_template_directory().'/resources/views/frontend/src/views',
        'parser'    =>      'controller',
    ],


    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be
    | stored for your application. Typically, this is within the uploads
    | directory. However, as usual, you are free to change this value.
    |
    */

    'cache' => [
        'path' => wp_upload_dir()['basedir'].'/cache',
        'is_enabled' => !(WP_DEBUG),
    ],



    /*
    |--------------------------------------------------------------------------
    | View Namespaces
    |--------------------------------------------------------------------------
    |
    | Blade has an underutilized feature that allows developers to add
    | supplemental view paths that may contain conflictingly named views.
    | These paths are prefixed with a namespace to get around the conflicts.
    | A use case might be including views from within a plugin folder.
    |
    */

    'namespaces' => [
        /* Given the below example, in your views use something like: @include('WC::some.view.or.partial.here') */
        // 'WC' => WP_PLUGIN_DIR.'/woocommerce/templates/',
    ],
];
