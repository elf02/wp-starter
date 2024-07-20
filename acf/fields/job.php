<?php

use Extended\ACF\Fields\WYSIWYGEditor;
use Extended\ACF\Location;

register_extended_field_group([
    'title' => 'Job',
    'fields' => [
        WYSIWYGEditor::make('Beschreibung', 'description')
            ->tabs('visual')
            ->disableMediaUpload()
            ->lazyLoad(),

    ],
    'location' => [
        Location::where('post_type', 'job'),
    ],
]);
