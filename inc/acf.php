<?php

// Only show ACF Admin Menu on WP_LOCAL_DEV
function acf__filter_show_admin($show) {
  return (defined('WP_LOCAL_DEV') && WP_LOCAL_DEV);
}
add_filter('acf/settings/show_admin', 'acf__filter_show_admin');


// Blocks
function acf__action_acf_init() {
  if (!function_exists('acf_register_block')) {
    return;
  }

  acf_register_block(array(
    'name' => 'example_block',
    'title' => __('Example Block'),
    'description' => __('A custom example block.'),
    'render_template' => 'template-parts/acf/blocks/example.php',
    'category' => 'formatting',
    'icon' => 'admin-comments',
    'keywords' => array('example'),
  ));
}
//add_action('acf/init', 'acf__action_acf_init');
