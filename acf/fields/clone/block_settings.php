<?php

use Extended\ACF\Fields\Select;
use Extended\ACF\Fields\TrueFalse;

return [
    Select::make('Abstände', 'block_spacing')
        ->choices([
            '80' => '80%',
            '100' => '100%'
        ])
        ->default('80')
        ->format('value')
        ->stylized()
        ->lazyLoad(),

    TrueFalse::make('Sichtbar', 'block_visibility')
        ->default(true)
        ->stylized(on: 'Ja', off: 'Nein'),
];