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

global $wpshop_core;
global $wpshop_template;
global $wpshop_rating;
global $big_thumbnail_image;
global $thumb_url;

$thumb = get_the_post_thumbnail( $post->ID, apply_filters( THEME_SLUG . '_post_thumbnail', 'thumb-big' ), array( 'itemprop' => 'image' ) );

$structure_single_hide  = $wpshop_core->get_option( 'structure_single_hide' );
if ( ! empty( $structure_single_hide ) ) {
    $structure_single_hide = explode( ',', $structure_single_hide );
} else {
    $structure_single_hide = array();
}

$is_show_title_h1      = $wpshop_core->is_show_element( 'title_h1' );
$is_show_meta          = $wpshop_core->is_show_element( 'meta' );
$is_show_thumb         = ( ! in_array( 'thumbnail', $structure_single_hide ) && $wpshop_core->is_show_element( 'thumbnail' ) );
$is_show_social_top    = ( ! in_array( 'social_top', $structure_single_hide ) && $wpshop_core->is_show_element( 'social_top' ) );
$is_show_excerpt       = ( ! in_array( 'excerpt', $structure_single_hide ) && $wpshop_core->is_show_element( 'excerpt' ) );
$is_show_author_box    = ( ! in_array( 'author_box', $structure_single_hide ) && $wpshop_core->is_show_element( 'author_box' ) );
$is_show_social_bottom = ( ! in_array( 'social_bottom', $structure_single_hide ) && $wpshop_core->is_show_element( 'social_bottom' ) );
$is_show_rating        = ( ! in_array( 'rating', $structure_single_hide ) && $wpshop_core->is_show_element( 'rating' ) );
$is_show_tags          = ( ! in_array( 'tags', $structure_single_hide ) );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'article-post' ); ?>>

    <?php if ( $is_show_title_h1 ) { ?>
        <?php do_action( THEME_SLUG . '_single_before_title' ) ?>
        <h1 class="entry-title" itemprop="<?php echo ( is_recipe() ) ? 'name' : 'headline'; ?>"><?php the_title() ?></h1>
        <?php do_action( THEME_SLUG . '_single_after_title' ) ?>
    <?php } ?>


    <?php if ( ! $big_thumbnail_image ) : ?>

        <?php if ( $is_show_meta ) { ?>
            <div class="entry-meta">
                <?php get_template_part( 'template-parts/boxes/entry', 'meta' ) ?>
            </div>
        <?php } ?>

        <?php if ( $is_show_social_top ) { ?>
            <?php get_template_part( 'template-parts/social', 'buttons' ); ?>
        <?php } ?>

        <?php if ( $is_show_thumb && ! empty( $thumb ) ) : ?>
            <div class="entry-image">
                <?php echo $thumb; ?>
            </div>
        <?php endif; ?>

    <?php endif; ?>


    <?php
    $excerpt = get_the_excerpt();
    if ( has_excerpt() && $is_show_excerpt ) {
        do_action( THEME_SLUG . '_single_before_excerpt' );
        echo '<div class="entry-excerpt">' . $excerpt . '</div>';
        do_action( THEME_SLUG . '_single_after_excerpt' );
    }
    ?>


    <div class="entry-content"<?php echo ( ! is_recipe() ) ? ' itemprop="articleBody"' : '' ; ?>>
        <?php

        do_action( THEME_SLUG . '_single_before_the_content' );
        the_content();
        do_action( THEME_SLUG . '_single_after_the_content' );

        wp_link_pages( array(
            'before'        => '<div class="page-links">' . esc_html__( 'Pages:', THEME_TEXTDOMAIN ),
            'after'         => '</div>',
            'link_before'   => '<span class="page-links__item">',
            'link_after'    => '</span>',
        ) );

        ?>
    </div>

</article>

<?php $wpshop_core->the_option( 'code_after_content' ) ?>

<?php
$source_link = get_post_meta( $post->ID, 'source_link', true );
$source_hide = get_post_meta( $post->ID, 'source_hide', true );

if ( ! empty( $source_link ) ) {
    echo '<div class="meta-source">';

    if ( $source_hide == 'checked' ) {
        echo '<span class="ps-link js-link" data-href="' . $source_link . '" data-target="_blank" rel="noopener">' . __( 'Source', THEME_TEXTDOMAIN ) . '</span>';
    } else {
        echo '<a href="'. $source_link .'" target="_blank">' . __( 'Source', THEME_TEXTDOMAIN ) . '</a>';
    }

    echo '</div>';
}
?>

<?php if ( $is_show_author_box ) get_template_part( 'template-parts/author', 'box' ); ?>

<?php if ( $is_show_social_bottom || $is_show_rating || $is_show_tags ) : ?>

<div class="entry-bottom">

    <?php if ( $is_show_social_bottom ) { ?>
        <div class="entry-social">
            <?php if ( apply_filters( THEME_SLUG . '_social_share_title_show', true ) ) : ?>
                <div class="entry-bottom__header"><?php echo apply_filters( THEME_SLUG . '_social_share_title', __( 'Share to friends', THEME_TEXTDOMAIN ) ) ?></div>
            <?php endif; ?>

            <?php get_template_part( 'template-parts/social', 'buttons' ) ?>
        </div>
    <?php } ?>

    <?php if ( $is_show_rating ) { ?>
        <div class="entry-rating">
            <div class="entry-bottom__header"><?php echo apply_filters( THEME_SLUG . '_rating_title', __( 'Rating', THEME_TEXTDOMAIN ) ) ?></div>
            <?php $post_id = $post ? $post->ID : 0; $wpshop_rating->the_rating( $post_id, apply_filters( THEME_SLUG . '_rating_text_show', true ) ); ?>
        </div>
    <?php } ?>

    <?php if ( $is_show_tags ) {
        $post_tags = get_the_tags();
        if ( $post_tags ) {
            echo '<div class="entry-tags">';
            echo '<div class="entry-bottom__header">' . __( 'Tags:', THEME_TEXTDOMAIN ) . '</div>';
            foreach( $post_tags as $tag ) {
                echo '<a href="'. get_tag_link( $tag->term_id ) .'" class="entry-tag">'. $tag->name . '</a> ';
            }
            echo '</div>';
        }
    } ?>

</div><!--.entry-bottom-->

<?php endif; ?>

<?php if ( is_recipe() ) { ?>
    <?php
    $post_tags = get_the_tags();
    $keywords = [];

    if ( $post_tags && is_array( $post_tags ) ) {
        foreach ( $post_tags as $tag ) {
            $keywords[] = $tag->name;
        }

        echo '<meta itemprop="keywords" content="' . implode( ', ', $keywords ) . '">';
    }
    ?>
    <meta itemprop="recipeCuisine" content="<?php $category = get_the_category(); echo $category[0]->cat_name; ?>">
<?php } ?>

<?php
    if ( is_recipe() ) {
        $schema_description = get_the_content();
        $schema_description = strip_shortcodes( $schema_description );
	    $schema_description = strip_tags( $schema_description );
	    echo '<meta itemprop="description" content="' . esc_attr( $schema_description ) . '">';
    }
?>

<meta itemprop="<?php echo ( is_recipe() ) ? 'recipeCategory' : 'articleSection' ; ?>" content="<?php $category = get_the_category(); echo $category[0]->cat_name; ?>">
<div itemprop="author" itemscope itemtype="http://schema.org/Person" style="display: none"><span itemprop="name"><?php echo esc_attr( get_the_author() ) ?></span></div>
<meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="<?php the_permalink() ?>" content="<?php the_title(); ?>">
<meta itemprop="dateModified" content="<?php the_modified_time('Y-m-d')?>">
<meta itemprop="datePublished" content="<?php the_time('c') ?>">
<?php echo $wpshop_template->get_microdata_publisher() ?>