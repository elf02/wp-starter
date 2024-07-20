<?php

if (!class_exists('ACF')) {
    throw new Exception('ACF Pro Plugin required!');
}

require_once get_template_directory() . '/vendor/autoload.php';

new \e02\Setup;
new \e02\Assets;
new \e02\ACF;
new \e02\CPT;
