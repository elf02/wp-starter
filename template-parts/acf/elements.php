<?php

if (have_rows('content_elements')):
  while(have_rows('content_elements')): the_row();

    get_template_part('template-parts/acf/elements/element', get_row_layout());

  endwhile;
endif;
