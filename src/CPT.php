<?php

namespace e02;

class CPT
{
    public function __construct()
    {
        $this->hooks();
    }

    protected function hooks()
    {
        add_action('init', [$this, 'register_cpts']);
    }

    public function register_cpts()
    {
        foreach (glob(get_template_directory() . '/cpt/*.php') as $cpt_path) {
            require $cpt_path;
        }
    }
}
