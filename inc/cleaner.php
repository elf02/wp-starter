<?php

add_filter('xmlrpc_enabled', '__return_false');

function cleaner__clean_wp_head() {
  remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
  remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
  remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
  remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
  remove_action('wp_head', 'index_rel_link'); // index link
  remove_action('wp_head', 'parent_post_rel_link', 10, 0); // prev link
  remove_action('wp_head', 'start_post_rel_link', 10, 0); // start link
  remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
  remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
  remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
  remove_action('wp_head', 'rest_output_link_wp_head', 10);
}
add_action('after_setup_theme', 'cleaner__clean_wp_head');


// Remove Pingback
add_filter('wp_headers', function($headers) {
  unset($headers['X-Pingback']);
  return $headers;
});


function cleaner__disable_embeds_code() {
  // Remove the REST API endpoint.
  remove_action('rest_api_init', 'wp_oembed_register_route');
  // Turn off oEmbed auto discovery.
  add_filter('embed_oembed_discover', '__return_false');
  // Don't filter oEmbed results.
  remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
  // Remove oEmbed discovery links.
  remove_action('wp_head', 'wp_oembed_add_discovery_links');
  // Remove oEmbed-specific JavaScript from the front-end and back-end.
  remove_action('wp_head', 'wp_oembed_add_host_js');
  add_filter('tiny_mce_plugins', function ($plugins) {
    return array_diff($plugins, array('wpembed'));
  });
  // Remove all embeds rewrite rules.
  add_filter('rewrite_rules_array', function ($rules) {
    foreach($rules as $rule => $rewrite) {
        if(false !== strpos($rewrite, 'embed=true')) {
            unset($rules[$rule]);
        }
    }
    return $rules;
  });
  // Remove filter of the oEmbed result before any HTTP requests are made.
  remove_filter('pre_oembed_result', 'wp_filter_pre_oembed_result', 10);
}
add_action('init', 'cleaner__disable_embeds_code', 9999);


function cleaner__disable_feed() {
  wp_die(__('Kein Feed verfügbar. Bitte besuchen Sie unsere <a href="'. get_bloginfo('url') .'">Startseite</a>!'));
}
add_action('do_feed', 'cleaner__disable_feed', 1);
add_action('do_feed_rdf', 'cleaner__disable_feed', 1);
add_action('do_feed_rss', 'cleaner__disable_feed', 1);
add_action('do_feed_rss2', 'cleaner__disable_feed', 1);
add_action('do_feed_atom', 'cleaner__disable_feed', 1);


function cleaner__disable_emojis() {
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('admin_print_scripts', 'print_emoji_detection_script');
  remove_action('wp_print_styles', 'print_emoji_styles');
  remove_action('admin_print_styles', 'print_emoji_styles');
  remove_filter('the_content_feed', 'wp_staticize_emoji');
  remove_filter('comment_text_rss', 'wp_staticize_emoji');
  remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
  add_filter('tiny_mce_plugins', function($plugins) {
    return is_array($plugins) ? array_diff($plugins, array('wpemoji')) : array();
  });
}
add_action('init', 'cleaner__disable_emojis');


function cleaner__remove_dns_prefetch($hints, $relation_type) {
  if ($relation_type === 'dns-prefetch') {
    return array_diff(wp_dependencies_unique_hosts(), $hints);
  }
  return $hints;
}
add_filter('wp_resource_hints', 'cleaner__remove_dns_prefetch', 10, 2);
