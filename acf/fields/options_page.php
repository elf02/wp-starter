<?php

use Extended\ACF\Fields\WYSIWYGEditor;
use Extended\ACF\Location;

register_extended_field_group([
    'title' => 'Theme Einstellungen',
    'fields' => [
        WYSIWYGEditor::make('Text', 'text')
            ->tabs('visual')
            ->disableMediaUpload()
            ->lazyLoad(),

    ],
    'location' => [
        Location::where('options_page', 'e02-theme-settings'),
    ],
]);
