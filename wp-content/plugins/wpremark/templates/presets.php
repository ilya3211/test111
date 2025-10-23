<?php

use Wpshop\WPRemark\Plugin;
use Wpshop\WPRemark\PluginContainer;
use Wpshop\WPRemark\Templates;

if ( ! defined( 'WPINC' ) ) {
    die;
}

$class_templates = PluginContainer::get( Templates::class );

$display_none = function ( $hide ) {
    if ( $hide ) {
        echo ' style="display:none"';
    }
};
?>
<div class="wrap">
    <h2><?php echo __( 'Presets', Plugin::TEXT_DOMAIN ) ?></h2>

    <div><?php echo __( 'On this page you can add new presets to the editor or delete the current ones.', Plugin::TEXT_DOMAIN ) ?></div>

    <div class="wpremark-templates-preview js-wpremark-templates-preview">

        <?php if ( is_wp_error( $presets = $class_templates->load_templates_transient(  ) ) ): ?>

            <div class="error">
                <?php foreach ( $presets->errors as $code => $messages ): ?>
                    <?php foreach ( $messages as $message ): ?>
                        <p>
                            <span class="error-<?php echo esc_attr( $code ) ?>"><?php echo esc_html( $message ) ?></span>
                        </p>
                    <?php endforeach ?>
                <?php endforeach ?>
            </div>

        <?php else: ?>

            <?php

            $current_group = '';

            foreach ( $presets as $name => $template ):

                if ( $current_group != $template['_group'] ) {
                    $css_class_group = 'group';
                    $current_group = $template['_group'];
                } else {
                    $css_class_group = '';
                }

                // чистим от служебных атрибутов
                $shortcode = '[wpremark';
                $template_filtered = $class_templates->filter_service_attributes( $template );
                foreach ( $template_filtered as $k => $v ) {
                    $shortcode .= ' ' . $k . '="' . esc_attr( $v ) . '"';
                }
                $shortcode .= ']Пример блока внимания[/wpremark]';
                ?>

                <div class="wpremark-templates-preview-item wpremark-templates-preview-item--<?php echo $css_class_group ?> js-wpremark-templates-preview-item" data-name="<?php echo esc_attr( $name ) ?>">
                    <div class="wpremark-templates-preview-item__id">
                        <?php echo $template['_order'] ?>
                    </div>
                    <div class="wpremark-templates-preview-item__block">
                        <?php echo do_shortcode( $shortcode ) . PHP_EOL; ?>
                    </div>
                    <div class="wpremark-templates-preview-item__actions">
                        <div class="wpremark-templates-preview-item__result js-wpremark-templates-preview-item-result"></div>
                        <button class="wpremark-templates-btn wpremark-templates-btn--remove js-wpremark-templates-preview-item-remove"<?php $display_none( ! $class_templates->exists( $name ) ) ?>
                                data-action="wpremark_remove_preset">
                            <span class="dashicons dashicons-remove"></span>
                            <?php echo esc_html__( 'Remove', Plugin::TEXT_DOMAIN ) ?>
                        </button>
                        <button class="wpremark-templates-btn wpremark-templates-btn--download js-wpremark-templates-preview-item-import"<?php $display_none( $class_templates->exists( $name ) ) ?>
                                data-action="wpremark_import_preset">
                            <span class="dashicons dashicons-insert"></span>
                            <?php echo esc_html__( 'Download', Plugin::TEXT_DOMAIN ) ?>
                        </button>
                        <button class="wpremark-templates-btn wpremark-templates-btn--shortcode js-wpremark-templates-preview-item-copy-shortcode" data-text-copied="<?php echo __( 'Copied!', Plugin::TEXT_DOMAIN ) ?>">
                            <span class="dashicons dashicons-shortcode"></span>
                            <?php echo __( 'Shortcode', Plugin::TEXT_DOMAIN ) ?>
                        </button>
                        <div class="js-wpremark-templates-preview-item-shortcode" style="display: none;"><?php echo $shortcode ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif ?>

        <?php wp_nonce_field( 'wpremark-presets', 'wpremark_presets_nonce' ) ?>

    </div>
</div>
