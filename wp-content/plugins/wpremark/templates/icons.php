<?php

use Wpshop\WPRemark\Icons;
use Wpshop\WPRemark\Plugin;
use Wpshop\WPRemark\PluginContainer;
use Wpshop\WPRemark\Templates;

if ( ! defined( 'WPINC' ) ) {
    die;
}

$class_templates = PluginContainer::get( Templates::class );
$icons = new Icons();

$display_icon = function ( $item ) use ( $icons ) {
    echo '<div class="wpremark-icon-preview js-wpremark-icon-preview">';
    echo '<div class="wpremark-icon-preview__copied js-wpremark-icon-preview-copied">';
    echo '<svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 48c114.88 0 208 93.12 208 208s-93.12 208-208 208S48 370.88 48 256 141.12 48 256 48m0-48a256.05 256.05 0 00-99.66 491.86A256.05 256.05 0 00355.66 20.14 254.47 254.47 0 00256 0zm-23.27 361.24l149-149a24 24 0 00-33.94-33.94l-132 132-55.55-55.55a24 24 0 10-33.94 33.94l72.52 72.52a24 24 0 0033.94 0z" fill="currentColor"></path></svg> ';
    echo __( 'Copied', Plugin::TEXT_DOMAIN );
    echo '</div>';
    echo '<div class="wpremark-icon-preview__icon">';
    echo $icons->get_icon($item);
    echo '</div>';

    echo '<div class="wpremark-icon-preview__name js-wpremark-copy" data-copy="' . esc_attr( $item ) . '">' . $item . '</div>';
    echo '  <div class="wpremark-icon-preview__actions">';
    echo '    <div>';
    echo '      <span class="wpremark-icon-preview__action js-wpremark-copy" data-copy-shortcode="' . esc_attr( $item ) . '">Shortcode</span> ';
    echo '      <span class="wpremark-icon-preview__action js-wpremark-copy" data-copy-php="' . esc_attr( $item ) . '">PHP</span>';
    echo '    </div>';
    echo '  </div>';
    echo '</div>';
};
?>
<div class="wrap">
    <h2><?php echo __( 'Icons', Plugin::TEXT_DOMAIN ) ?></h2>


    <p>
        На этой странице вы можете посмотреть все иконки, которые есть в плагине, скопировать название, шорткод или PHP-код для вставки SVG-иконки.
        <br>
        К коду иконки будет применен размер и цвет, которые вы выберете в форме ниже. Подробнее в про этот раздел в <a href="#">нашей документации</a>.
    </p>

    <div class="wpremark-icon-filter">
        <div class="wpremark-icon-filter__size">
            <label for="size">Размер:</label>
            <input type="range" min="16" max="64" step="4" value="32" id="size" class="wpremark-range js-wpremark-icon-preview-size">
            <span class="js-wpremark-icon-preview-size-text">32</span>
        </div>
        <div class="wpremark-icon-filter__color">
            <label for="color">Цвет:</label>
            <input type="text" id="color" value="" class="js-wpremark-icon-preview-color" data-default-color="" />
        </div>
    </div>

    <div class="wpremark-admin-icons js-wpremark-admin-icons wpremark-admin-icons--32">

        <?php

        $icons_grouped = [];

        foreach ( $icons->get_groups() as $group_key => $group ) {
            echo '<div>';
            echo '<h2>' . $group['name'] . '</h2>';
            echo '<div class="wpremark-icon-preview-container js-wpremark-icon-preview-container">';

            foreach ( $group['items'] as $item ) {

                $display_icon( $item );

                $icons_grouped[] = $item;

            }

            echo '</div>';
            echo '</div>';
        }

        $icons_left = [];
        foreach ( $icons->get_icons() as $icon_name => $icon ) {
            if ( ! in_array( $icon_name, $icons_grouped ) ) {
                $icons_left[] = $icon_name;
            }
        }

        if ( ! empty( $icons_left ) ) {
            echo '<div>';
            echo '<h2>Other</h2>';
            echo '<div class="wpremark-icon-preview-container js-wpremark-icon-preview-container">';

            foreach ( $icons_left as $item ) {
                $display_icon( $item );
            }

            echo '</div>';
            echo '</div>';
        }
        ?>

    </div>
</div>