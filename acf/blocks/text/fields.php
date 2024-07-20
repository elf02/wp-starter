<?php

use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\WYSIWYGEditor;

return [
    Tab::make('Inhalt')
        ->selected(),

    WYSIWYGEditor::make('Text', 'text')
        ->tabs('visual')
        ->disableMediaUpload()
        ->lazyLoad()
        ->required(),

    Tab::make('Einstellungen'),

    require(get_template_directory() . '/acf/fields/clone/block_settings.php'),
];