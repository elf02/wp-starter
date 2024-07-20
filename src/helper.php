<?php

namespace e02;

function fields($post_id = false, $format_value = true, $items = [])
{
    if (!empty($items)) {
        return new ACFields($items);
    } else {
        return ACFields::createFromFields($post_id, $format_value);
    }
}

function flatten($array, $result = [])
{
    foreach ($array as $flat) {
        if (is_array($flat)) {
            $result = flatten($flat, $result);
        } else {
            $result[] = $flat;
        }
    }

    return $result;
}

function local_env()
{
   return in_array(wp_get_environment_type(), ['local', 'development']);
}

function str_swap($str, array $swap)
{
    return str_replace(array_keys($swap), array_values($swap), $str);
}

function local_date($datetime = 'now', $immutable = false)
{
    return $immutable ?
        new \DateTimeImmutable($datetime, wp_timezone()) :
        new \DateTime($datetime, wp_timezone());
}

function local_date_from_format($datetime, $format = 'Y-m-d H:i:s', $immutable = false)
{
    return $immutable ?
        \DateTimeImmutable::createFromFormat($format, $datetime, wp_timezone()) :
        \DateTime::createFromFormat($format, $datetime, wp_timezone());
}

function ar_responsive_image($image_id, $image_size, $max_width, $lazyload = false, $lazyload_native = true)
{
    if ($image_id != '') {
        $image_src = wp_get_attachment_image_url($image_id, $image_size);
        $image_srcset = wp_get_attachment_image_srcset($image_id, $image_size);

        $attr = [
            '%src%' => $image_src,
            '%srcset%' => $image_srcset,
            '%mw%' => $max_width,
        ];

        if ($lazyload) {
            if ($lazyload_native) {
                echo str_swap('loading="lazy" src="%src%" srcset="%srcset%" sizes="(max-width: %mw%) 100vw, %mw%"', $attr);
            } else {
                echo str_swap('data-src="%src%" data-srcset="%srcset%" sizes="(max-width: %mw%) 100vw, %mw%"', $attr);
            }
        } else {
            echo str_swap('src="%src%" srcset="%srcset%" sizes="(max-width: %mw%) 100vw, %mw%"', $attr);
        }
    }
}

function bootstrap_pagination(\WP_Query $wp_query = null, $echo = true, $params = [])
{
    if (null === $wp_query) {
        global $wp_query;
    }

    $add_args = [];

    //add query (GET) parameters to generated page URLs
    /*if (isset($_GET[ 'sort' ])) {
      $add_args[ 'sort' ] = (string)$_GET[ 'sort' ];
    }*/

    $pages = paginate_links(
        array_merge([
            'base'         => str_replace(999999999, '%#%', html_entity_decode(get_pagenum_link(999999999))),
            'format'       => '?paged=%#%',
            'current'      => max(1, get_query_var('paged')),
            'total'        => $wp_query->max_num_pages,
            'type'         => 'array',
            'show_all'     => false,
            'end_size'     => 3,
            'mid_size'     => 1,
            'prev_next'    => true,
            'prev_text'    => __('« Prev'),
            'next_text'    => __('Next »'),
            'add_args'     => $add_args,
            'add_fragment' => ''
        ], $params)
    );

    if (is_array($pages)) {
        //$current_page = ( get_query_var( 'paged' ) == 0 ) ? 1 : get_query_var( 'paged' );
        $pagination = '<div class="pagination"><ul class="pagination">';

        foreach ($pages as $page) {
            $pagination .= '<li class="page-item' . (strpos($page, 'current') !== false ? ' active' : '') . '"> ' . str_replace('page-numbers', 'page-link', $page) . '</li>';
        }

        $pagination .= '</ul></div>';

        if ($echo) {
            echo $pagination;
        } else {
            return $pagination;
        }
    }

    return null;
}

// The Loop PHP generator
function loop($iterable = null)
{
    if (null === $iterable) {
        $iterable = $GLOBALS['wp_query'];
    }

    $posts = $iterable;

    if (is_object($iterable) && property_exists($iterable, 'posts')) {
        $posts = $iterable->posts;
    }

    if (!is_array($posts)) {
        throw new \InvalidArgumentException(sprintf('Expected an array, received %s instead', gettype($posts)));
    }

    global $post;

    $save_post = $post;

    try {
        foreach ($posts as $post) {
            setup_postdata($post);
            yield $post;
        }
    } finally {
        wp_reset_postdata();
        $post = $save_post;
    }
}
