<?php

namespace e02;

class ACF
{
    public function __construct()
    {
        $this->hooks();
    }

    protected function hooks()
    {
        add_action('init', [$this, 'register_blocks']);
        add_filter('allowed_block_types_all', [$this, 'filter_allowed_block_types'], 10, 2);
        add_action('after_setup_theme', [$this, 'add_options_page']);
        add_filter('acf/load_field/name=block_spacing', [$this, 'load_block_spacing_choices']);
        add_filter('e02/block/classes', [$this, 'add_global_block_classes'], 10, 3);

        // Hide ACF menu
        add_filter('acf/settings/show_admin', '__return_false');
    }

    // Register ACF blocks + fields
    public function register_blocks()
    {
        // Blocks + related fields
        foreach (glob(get_template_directory() . '/acf/blocks/*', GLOB_ONLYDIR) as $block_path) {
            if ($block = register_block_type($block_path)) {
                register_extended_field_group([
                    'title' => $block->title,
                    'fields' => flatten(require $block_path . '/fields.php'),
                    'location' => [
                        \Extended\ACF\Location::where('block', $block->name),
                    ],
                ]);
            }
        }

        // Fields
        foreach (glob(get_template_directory() . '/acf/fields/*.php') as $field_path) {
            require $field_path;
        }
    }

    // Filtered blocks
    public function filter_allowed_block_types($allowed_block_types, $editor_context)
    {
        $allowed_blocks = [
            'core/paragraph'
        ];

        $allowed_acf_blocks = array_keys(acf_get_block_types());

        return array_merge($allowed_blocks, $allowed_acf_blocks);
    }


    // Theme settings page
    public function add_options_page()
    {
        acf_add_options_page([
            'page_title'        => 'Theme Einstellungen',
            'menu_title'        => 'Theme Einstellungen',
            'menu_slug'         => 'e02-theme-settings',
            'update_button'     => 'Einstellungen speichern',
            'updated_message'   => 'Einstellungen gespeichert',
            'capability'        => 'edit_posts',
            'redirect'          => false
        ]);
    }


    // Block spacing field
    public function load_block_spacing_choices($field)
    {
        $field['choices'] = [
            'block-my-none' => 'kein Abstand',
            'block-my-default' => 'Oben/Unten 80px',
            'block-my-80-0' => 'Oben 80px / Unten 0px',
            'block-my-0-80' => 'Oben 0px / Unten 80px',
        ];

        $field['default_value'] = 'block-my-default';

        return $field;
    }


    // Block class filter
    public function add_global_block_classes($class, $block, $fields)
    {
        $class[] = strtolower(sanitize_html_class($block['title'])) . '-block';

        // Block settings
        $class[] = $fields->block_visibility ? '' : 'd-none';
        $class[] = $fields->block_spacing ?? 'block-my-default';

        $class[] = $block['className'] ?? '';

        return array_filter($class);
    }
}
