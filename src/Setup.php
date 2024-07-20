<?php

namespace e02;

class Setup
{
    public function __construct()
    {
        $this->hooks();
    }

    protected function hooks()
    {
        add_action('after_setup_theme', [$this, 'register_image_sizes']);
        add_action('after_setup_theme', [$this, 'register_menus']);
        add_action('after_setup_theme', [$this, 'register_html_support']);

        // define('WP_ENVIRONMENT_TYPE', 'local') in wp-config.php
        if (local_env()) {
            add_action('phpmailer_init', [$this, 'smtp_mailpit']);
        }
    }

    public function register_image_sizes()
    {
        add_image_size('hero-1920x750', 1920, 750, ['center', 'center']);
    }

    public function register_menus()
    {
        register_nav_menus([
            'main-nav' => 'Hauptnavigation',
            'footer-nav' => 'Footer-Navigation',
        ]);
    }

    public function register_html_support()
    {
        add_theme_support('html5', array('script', 'style' ));
    }

    public function smtp_mailpit($phpmailer)
    {
        $phpmailer->IsSMTP();
        $phpmailer->Host = '127.0.0.1';
        $phpmailer->Port = 1025;
        $phpmailer->Username = '';
        $phpmailer->Password = '';
        $phpmailer->SMTPAuth = true;
    }
}
