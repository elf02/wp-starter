<?php

use Extended\ACF\Fields\WYSIWYGEditor;
use Extended\ACF\Location;

register_extended_field_group([
    'title' => 'Seite',
    'fields' => [
        WYSIWYGEditor::make('Text', 'text')
            ->tabs('visual')
            ->disableMediaUpload()
            ->lazyLoad(),

    ],
    'location' => [
        Location::where('post_type', 'page'),
    ],
]);
