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
$section_classes = [];

$html_code = '';

if ( ! empty( $section_options['section_header_text'] ) ) {
	$section_header_text = $section_options['section_header_text'];
}

if ( ! empty( $section_options['title_tag'] ) ) {
    $title_tag = $section_options['title_tag'];
}

if ( ! empty( $section_options['preset'] ) ) {
	$section_classes[] = 'section-preset--' . $section_options['preset'];
}

if ( ! empty( $section_options['section_css_classes'] ) ) {
    $section_classes[] .= $section_options['section_css_classes'];
}

if ( ! empty( $section_options['html_code'] ) ) {
	$html_code = $section_options['html_code'];
}

?>

<div class="section-block section-html <?php echo implode( ' ', $section_classes ) ?>">
    <?php if ( ! empty( $section_header_text ) ) { ?>
        <div class="section-block__header">
            <<?php echo $title_tag ?> class="section-block__title"><?php echo do_shortcode( $section_header_text ) ?></<?php echo $title_tag ?>>
        </div>
    <?php } ?>

    <div class="section-html__body">
        <?php echo do_shortcode( $html_code ) ?>
    </div>
</div><!--.section-posts-->