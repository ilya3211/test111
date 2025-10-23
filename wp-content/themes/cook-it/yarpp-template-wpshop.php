<?php
/**
 * YARPP Template: WPShop YARPP Template
 * Description: WPShop YARPP Template
 * Author: WPShop
 */

global $wpshop_advertising;
?>

<?php if ( have_posts() ) : ?>

<!-- yarpp -->
<div class="b-related">

    <?php do_action( THEME_SLUG . '_before_related' ) ?>

    <div class="b-related__header"><span><?php echo apply_filters( THEME_SLUG . '_related_title', __( 'Related articles', THEME_TEXTDOMAIN ) ) ?></span></div>

    <?php echo $wpshop_advertising->show_ad( 'before_related' ) ?>

    <div class="b-related__items posts-container posts-container--small">
        <?php
            while ( have_posts() ) : the_post();
                get_template_part( 'template-parts/posts/content', 'related' );
            endwhile;
        ?>
    </div>

    <?php echo $wpshop_advertising->show_ad( 'after_related' ) ?>

    <?php do_action( THEME_SLUG . '_after_related' ) ?>

</div>

<?php else : ?>
<!-- no YARPP related -->
<?php endif ?>
