<?php

register_post_type('job', array(
    'labels' => array(
        'name'               => __('Jobs'),
        'singular_name'      => __('Job'),
        'add_new'            => __('Neuer Job'),
        'add_new_item'       => __('Neuen Job anlegen'),
        'edit_item'          => __('Job editieren'),
        'new_item'           => __('Neuer Job'),
        'all_items'          => __('Alle Jobs'),
        'view_item'          => __('Jobs anzeigen'),
        'search_items'       => __('Job suchen'),
        'not_found'          => __('Keine Jobs gefunden'),
        'not_found_in_trash' => __('Keine Jobs im Papierkorb gefunden'),
        'parent_item_colon'  => '',
        'menu_name'          => __('Jobs')
    ),
    'description' => 'Jobs',
    'public' => true,
    'show_ui' => true,
    'has_archive' => false,
    'supports' => array('title', 'editor'),
    'rewrite' => array('slug' => 'job'),
    'menu_icon' => 'dashicons-groups'
));
