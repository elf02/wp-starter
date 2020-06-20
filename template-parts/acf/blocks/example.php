<?php

/**
 * Example Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$id = 'example-' . $block['id'];
?>

<div id="<?= esc_attr($id) ?>">
    <p>Example Block</p>
</div>
