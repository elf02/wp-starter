<?php

namespace e02;

class Assets
{
    public function __construct()
    {
        $this->hooks();
    }

    protected function hooks()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    protected function asset_hash($path)
    {
        return substr(md5_file($path), 0, 10);
    }

    public function enqueue_scripts()
    {
        // vendor js
        wp_enqueue_script(
            'e02-vendor',
            get_theme_file_uri('assets/dist/js/vendor.js'),
            ['jquery'],
            $this->asset_hash(get_theme_file_path('assets/dist/js/vendor.js')),
            true
        );

        // main js
        wp_enqueue_script(
            'e02-main',
            get_theme_file_uri('assets/dist/js/scripts.js'),
            ['e02-vendor'],
            $this->asset_hash(get_theme_file_path('assets/dist/js/scripts.js')),
            true
        );

        // vendor css
        wp_enqueue_style(
            'e02-vendor',
            get_theme_file_uri('assets/dist/css/vendor.css'),
            [],
            $this->asset_hash(get_theme_file_path('assets/dist/css/vendor.css')),
        );

        // main css
        wp_enqueue_style(
            'e02-main',
            get_theme_file_uri('assets/dist/css/style.css'),
            ['e02-vendor'],
            $this->asset_hash(get_theme_file_path('assets/dist/css/style.css')),
        );
    }
}
