<?php

use Extended\ACF\Fields\Select;

return [
    Select::make('Layout', 'layout')
        ->choices([
            '80' => '80%',
            '100' => '100%'
        ])
        ->default('80')
        ->format('value')
        ->stylized()
        ->lazyLoad(),

    require(get_template_directory() . '/acf/fields/clone/block_settings.php'),
];