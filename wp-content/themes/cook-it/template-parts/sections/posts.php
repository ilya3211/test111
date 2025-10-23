<?php
/**
 * ****************************************************************************
 *
 *   DON'T EDIT THIS FILE
 *   After update you will lose all changes. Use child theme
 *
 *   НЕ РЕДАКТИРУЙТЕ ЭТОТ ФАЙЛ
 *   После обновления Вы потереяете все изменения. Используйте дочернюю тему
 *
 *   https://support.wpshop.ru/docs/general/child-themes/
 *
 * *****************************************************************************
 *
 * @package cook-it
 */

global $wpshop_helper;
global $wpshop_template;

$section_options = ( isset( $section_options ) ) ? $section_options : [];

// default
$section_header_text = '';
$title_tag = 'div';
$output_header_category = true;
$output_header_link = false;
$show_subcategories = true;
$section_classes = [];
$post_orderby = 'date';
$posts_meta_key = '';
$post_card_type = 'small';

if ( ! empty( $section_options['title_tag'] ) ) {
    $title_tag = $section_options['title_tag'];
}

if ( ! empty( $section_options['section_header_text'] ) ) {
    $section_header_text = $section_options['section_header_text'];
}

if ( isset( $section_options['output_header_category'] ) && $section_options['output_header_category'] == false ) {
    $output_header_category = false;
}

if ( isset( $section_options['output_header_link'] ) && $section_options['output_header_link'] ) {
    $output_header_link = true;
}

// prepare categories
if ( ! empty( $section_options['cat'] ) ) {

    $cat_children = [];
    $cat_ids = \Wpshop\Core\Helper::parse_ids_from_string( $section_options['cat'] );

	foreach ( $cat_ids as $cat_id ) {
        if ( $output_header_link ) {
            $section_header_category = '<a href="' . get_category_link( $cat_id ) . '">' . get_the_category_by_ID( $cat_id ) . '</a>';
        } else {
            $section_header_category = get_the_category_by_ID( $cat_id );
        }

        if ( $output_header_category ) {
            if ( ! empty( $section_header_text ) ) {
                $section_header_text .= ', ' . $section_header_category;
            } else {
                $section_header_text = $section_header_category;
            }
        }

		$term_children = get_term_children( $cat_id, 'category' );
	    if ( is_array( $term_children ) ) {
		    $cat_children = array_merge( $cat_children, $term_children );
        }
    }

}

if ( isset( $section_options['show_subcategories'] ) && $section_options['show_subcategories'] == false ) {
    $show_subcategories = false;
}

if ( ! empty( $section_options['preset'] ) ) {
	$section_classes[] = 'section-preset--' . $section_options['preset'];
}

if ( ! empty( $section_options['post_order'] ) ) {
    $post_order = $section_options['post_order'];

    $post_meta_query = [
        [
            'key' => '_thumbnail_id',
            'compare' => 'EXISTS'
        ],
    ];

    if ( $post_order == 'rand' ) {
        $post_orderby = 'rand';
    }

    if ( $post_order == 'views' ) {
        $post_orderby  = 'meta_value_num';
        $posts_meta_key = 'views';
    }

    if ( $post_order == 'comments' ) {
        $post_orderby = 'comment_count';
    }

    if ( $post_order == 'new' ) {
        $post_orderby = 'date';
    }
}

if ( ! empty( $section_options['post_card_type'] ) ) {
	$post_card_type = $section_options['post_card_type'];
}

if ( isset( $section_options['show_thumbnails'] ) && $section_options['show_thumbnails'] == 'hide' ) {
    $section_classes[] = 'is-show-thumbnails-false';
} else {
	$section_classes[] = 'is-show-thumbnails-true';
}

if ( ! empty( $section_options['section_css_classes'] ) ) {
    $section_classes[] .= $section_options['section_css_classes'];
}


/**
 * Prepare query
 */
$args = [
    'posts_per_page' => 4,
    'meta_key'       => $posts_meta_key,
    'orderby'        => $post_orderby,
];

if ( ! empty( $section_options['cat'] ) ) {
    $args['cat'] = $section_options['cat'];
}
if ( ! empty( $section_options['post__not_in'] ) ) {
    $args['post__not_in'] = \Wpshop\Core\Helper::parse_ids_from_string( $section_options['post__not_in'] );
}
if ( ! empty( $section_options['post__in'] ) ) {
    $args['post__in'] = \Wpshop\Core\Helper::parse_ids_from_string( $section_options['post__in'] );
}
if ( ! empty( $section_options['posts_per_page'] ) ) {
    $args['posts_per_page'] = (int) $section_options['posts_per_page'];
}
if ( ! empty( $section_options['offset'] ) ) {
    $args['offset'] = (int) $section_options['offset'];
}

$section_posts = get_posts( apply_filters( THEME_SLUG . '_home_constructor_get_posts_args', $args ) );

?>

<div class="section-block section-posts <?php echo implode( ' ', $section_classes ) ?>">
    <?php if ( ! empty( $section_header_text ) || ( ( ! empty( $cat_children ) && $show_subcategories ) ) ) : ?>
    <div class="section-block__header">
        <<?php echo $title_tag ?> class="section-block__title"><?php echo do_shortcode( $section_header_text ) ?></<?php echo $title_tag ?>>

        <?php if ( ! empty( $cat_children ) && $show_subcategories ) : ?>
        <div class="section-posts__categories">
            <div class="section-posts__categories-title"><?php echo apply_filters( THEME_SLUG . '_section_posts_categories_title', __( 'Subsections', THEME_TEXTDOMAIN ) ) ?></div>

            <?php
            if ( empty( $cat_ids ) ) $cat_ids = [];
            $categories = get_categories( apply_filters( THEME_SLUG . '_home_constructor_get_categories_args', [
                'orderby' => 'count',
                'order'   => 'DESC',
                'include' => $cat_children,
            ], $cat_ids ) );

            echo '<ul>';
            foreach( $categories as $category ) {
	            echo '<li><a href="' . get_term_link( $category->term_id ) . '">' . $category->name.'</a></li> ';
            }
            echo '</ul>';
            ?>

        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <div class="post-cards posts-container--<?php echo $post_card_type ?>">

        <?php
        foreach ( $section_posts as $post ) :
            setup_postdata( $post );
            get_template_part( 'template-parts/posts/content-card-' . $post_card_type );
        endforeach;
        wp_reset_postdata();
        ?>

    </div><!--.post-cards-->
</div><!--.section-posts-->