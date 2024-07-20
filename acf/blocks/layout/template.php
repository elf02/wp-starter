<?php

$fields = \e02\fields();

$class = apply_filters('e02/block/classes', [], $block, $fields);

$layout_class = [
    $fields->layout === '100' ? 'container-fluid px-0' : 'container-lg px-4 px-lg-0'
];

?>


<?php if ($is_preview): ?>
    <div style="padding: 10px; border: 2px solid #1a7b91;">
        <strong style="color: #1a7b91;">Layout</strong>
        <InnerBlocks  />
    </div>
<?php else: ?>
    <div class="<?= esc_attr(implode(' ', $class)) ?>"<?php if (!empty($block['anchor'])): ?> id="<?= esc_attr($block['anchor']) ?>"<?php endif; ?>>
      <div class="<?= esc_attr(implode(' ', $layout_class)) ?>">
        <InnerBlocks />
      </div>
    </div>
<?php endif; ?>