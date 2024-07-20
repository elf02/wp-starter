<?php get_header(); ?>

<main class="container-lg px-4 px-lg-0">
    <?php
        if (have_posts()) {
            foreach (e02\loop() as $post) {
                get_template_part('template-parts/content', get_post_type());
            }
        }
    ?>
</main>

<?php get_footer(); ?>