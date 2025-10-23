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
global $wpshop_partner;

$is_show_footer      = $wpshop_core->is_show_element( 'footer' );
$is_show_footer_menu = $wpshop_core->is_show_element( 'footer_menu' );
$is_show_arrow       = $wpshop_core->get_option( 'structure_arrow' );
$is_show_arrow_mob   = ( $wpshop_core->get_option( 'structure_arrow_mob' ) ) ? ' data-mob="on"' : '';

?>


    <?php do_action( THEME_SLUG . '_before_footer' ); ?>
    
    <?php
    if ( $is_show_footer_menu ) {
        get_template_part( 'template-parts/navigation/footer' );
    }
    ?>
    
    <?php if ( $is_show_footer ) { ?>
        <footer class="site-footer <?php $wpshop_core->the_option( 'footer_width' ) ?>" itemscope itemtype="http://schema.org/WPFooter">
            <div class="site-footer-inner <?php $wpshop_core->the_option( 'footer_inner_width' ) ?>">

                <?php get_template_part( 'template-parts/footer/footer', 'widgets' ); ?>

                <div class="footer-bottom">
                    <div class="footer-info">
                        <?php
                        $footer_copyright = $wpshop_core->get_option( 'footer_copyright' );
                        $footer_copyright = str_replace( '%year%', date( 'Y' ), $footer_copyright );
                        echo $footer_copyright;
                        ?>

                        <?php if ( 'yes' == $wpshop_core->get_option( 'wpshop_partner_enable' ) ) : ?>
                            <!--noindex-->
                            <div class="footer-partner">
                                <?php
                                $wpshop_partner->the_link( [
                                    'prefix' => $wpshop_core->get_option( 'wpshop_partner_prefix' ),
                                    'postfix' => $wpshop_core->get_option( 'wpshop_partner_postfix' ),
                                    'partner_id' => ( defined( 'WPSHOP_PARTNER' ) ) ? WPSHOP_PARTNER : 0,
                                ] );
                                ?>
                            </div>
                            <!--/noindex-->
                        <?php endif; ?>
                    </div>

                    <?php
                    $footer_counters = $wpshop_core->get_option( 'footer_counters' );
                    if ( ! empty( $footer_counters ) ) echo '<div class="footer-counters">' . $footer_counters . '</div>';
                    ?>
                </div>
        
            </div><!-- .site-footer-inner -->
        </footer>
    <?php } ?>

	<?php if ( $is_show_arrow ) { ?>
		<button type="button" class="scrolltop js-scrolltop"<?php echo $is_show_arrow_mob ?>></button>
    <?php } ?>
    
<?php do_action( THEME_SLUG . '_after_footer' ); ?>