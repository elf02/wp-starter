<?php

$fields = \e02\fields();

$class = apply_filters('e02/block/classes', [], $block, $fields);

?>

<section class="<?= esc_attr(implode(' ', $class)) ?>"<?php if (!empty($block['anchor'])): ?> id="<?= esc_attr($block['anchor']) ?>"<?php endif; ?>>
    <?= $fields->text ?>
</section>