<?php

function assets__action_wp_enqueue_scripts() {
  $assets_uri = get_template_directory_uri() . '/assets/dist';
  $assets_dir = get_template_directory() . '/assets/dist';

  $manifest_js = file_get_contents($assets_dir .'/scripts/manifest.js');
  $manifest = json_decode(
    file_get_contents($assets_dir . '/mix-manifest.json'),
    true
  );

  // deregister WP jQuery
  if (!is_admin()) {
    wp_deregister_script('jquery');
  }

  // Scripts
  wp_enqueue_script('vendor.js', $assets_uri . $manifest['/scripts/vendor.js'], [], null, true);
  wp_enqueue_script('main.js', $assets_uri . $manifest['/scripts/main.js'], [], null, true);
  wp_add_inline_script('vendor.js', $manifest_js, 'before');

  // Styles
  wp_enqueue_style('main.css', $assets_uri . $manifest['/styles/main.css'], [], null);

}
add_action('wp_enqueue_scripts', 'assets__action_wp_enqueue_scripts');
