<?php

if ( ! defined( 'WPINC' ) ) {
	die;
}

use Wpshop\WPRemark\Plugin;
use Wpshop\WPRemark\Icons;

$class_icons = new Icons();
$icon_images = $class_icons->get_icons();

?>

<script type="text/javascript">
    var wpremarkPreviewHelper = {
        icon: function (icon) {
            icons = <?php echo json_encode( $icon_images ) ?>;
            return icons[icon]['path'];
        },
        shadow_color: function (color) {
            if(color.substring(0,1) === '#') {
                color = color.substring(1);
            }

            aRgbHex = color.match(/.{1,2}/g);

            var r = parseInt(aRgbHex[0], 16);
            var g = parseInt(aRgbHex[1], 16);
            var b = parseInt(aRgbHex[2], 16);

            return r + ',' + g + ',' + b;
        },
        nl2br: function (str) {
            if (typeof str === 'string') {
                return str.replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1<br>');
            }
            return str;
        }
    };
</script>

<script type="text/html" id="tmpl-wpremark-live-preview">
    <{{data.tag}} class="wpremark wpremark--{{data.block_id}}" style="
    position: relative; display: flex; border: none;
    <# if (data.icon_show == true && (data.icon_position == 'top left' || data.icon_position == 'top center' || data.icon_position == 'top right' || data.icon_position == 'bottom left' || data.icon_position == 'bottom center' || data.icon_position == 'bottom right')) { #>flex-direction: column;<# } #>
    <# if (data.background_show == true && data.background_color) { #>background-color: {{data.background_color}};<# } #>
    <# if (data.background_show == true && data.background_image) { #>background-image: url({{data.background_image}});<# } #>
    <# if (data.background_show == true && data.background_image_repeat) { #>background-repeat: {{data.background_image_repeat}};<# } #>
    <# if (data.background_show == true && data.background_image_position) { #>background-position: {{data.background_image_position}};<# } #>
    <# if (data.background_show == true && data.background_image_size) { #>background-size: {{data.background_image_size}};<# } #>
    <# if (data.border_top == true) { #>border-top: {{data.border_width}}px {{data.border_style}} {{data.border_color}};<# } #>
    <# if (data.border_right == true) { #>border-right: {{data.border_width}}px {{data.border_style}} {{data.border_color}};<# } #>
    <# if (data.border_bottom == true) { #>border-bottom: {{data.border_width}}px {{data.border_style}} {{data.border_color}};<# } #>
    <# if (data.border_left == true) { #>border-left: {{data.border_width}}px {{data.border_style}} {{data.border_color}};<# } #>
    <# if (data.shadow_show == true) { #>box-shadow: {{data.shadow_x}}px {{data.shadow_y}}px {{data.shadow_blur}}px {{data.shadow_stretching}}px rgba({{{ wpremarkPreviewHelper.shadow_color(data.shadow_color) }}},{{data.shadow_opacity}});<# } #>
    <# if (data.padding_top) { #>padding-top: {{data.padding_top}}px;<# } #>
    <# if (data.padding_right) { #>padding-right: {{data.padding_right}}px;<# } #>
    <# if (data.padding_bottom) { #>padding-bottom: {{data.padding_bottom}}px;<# } #>
    <# if (data.padding_left) { #>padding-left: {{data.padding_left}}px;<# } #>
    <# if (data.margin_top) { #>margin-top: {{data.margin_top}}px;<# } #>
    <# if (data.margin_right) { #>margin-right: {{data.margin_right}}px;<# } #>
    <# if (data.margin_bottom) { #>margin-bottom: {{data.margin_bottom}}px;<# } #>
    <# if (data.margin_left) { #>margin-left: {{data.margin_left}}px;<# } #>
    <# if (data.border_radius) { #>border-radius: {{data.border_radius}}px;<# } #>">
        <# if (data.icon_show == true) { #><div class="wpremark-icon" style="
            <# if (data.icon_width) { #>max-width: 100%; flex: 0 0 auto;<# } #>
            <# if (data.icon_color) { #>color: {{data.icon_color}}; <# } #>
            <# if (data.icon_width) { #>width: {{data.icon_width}}px; <# } #>
            <# if (data.icon_height) { #>max-height: {{data.icon_height}}px; <# } #>
            <# if (data.icon_position == 'left top' || data.icon_position == 'left center' || data.icon_position == 'left bottom') { #>margin-right: {{data.icon_indent}}px;<# } #>
            <# if (data.icon_position == 'top left' || data.icon_position == 'top center' || data.icon_position == 'top right') { #>margin-bottom: {{data.icon_indent}}px;<# } #>
            <# if (data.icon_position == 'right top' || data.icon_position == 'right center' || data.icon_position == 'right bottom') { #>order: 10; margin-left: {{data.icon_indent}}px;<# } #>
            <# if (data.icon_position == 'bottom left' || data.icon_position == 'bottom center' || data.icon_position == 'bottom right') { #>order: 10; margin-top: {{data.icon_indent}}px;<# } #>
            <# if (data.icon_position == 'left center' || data.icon_position == 'right center' || data.icon_position == 'top center' || data.icon_position == 'bottom center') { #>align-self: center;<# } #>
            <# if (data.icon_position == 'left top' || data.icon_position == 'right top') { #>align-self: flex-start;<# } #>
            <# if (data.icon_position == 'left bottom' || data.icon_position == 'right bottom' || data.icon_position == 'top right' || data.icon_position == 'bottom right') { #>align-self: flex-end;<# } #>">
        <# if (!data.icon_image_custom) { #>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="{{data.icon_width}}" height="{{data.icon_height}}" style="max-width: 100%; max-height: 100%;"><path d="{{{ wpremarkPreviewHelper.icon(data.icon_image) }}}" fill="currentColor"/></svg>
        <# } else { #>
            <img src="{{data.icon_image_custom}}" width="{{data.icon_width}}" height="{{data.icon_height}}" alt="" style="max-width: 100%; max-height: 100%;">
        <# } #>
        </div><# } #>
        <div class="wpremark-body">
            <# if (data.title_show == true && data.title_text) { #><div class="wpremark-title" style="
            <# if (data.title_align && data.title_align != 'no') { #>text-align: {{data.title_align}};<# } #>
            <# if (data.title_color) { #>color: {{data.title_color}};<# } #>
            <# if (data.title_bold == true) { #>font-weight: bold; <# } #>
            <# if (data.title_italic == true) { #>font-style: italic; <# } #>
            <# if (data.title_underline == true) { #>text-decoration: underline; <# } #>
            <# if (data.title_uppercase == true) { #>text-transform: uppercase; <# } #>
            <# if (data.title_font_size) { #>font-size: {{data.title_font_size}}px;<# } #>
            <# if (data.title_line_height) { #>line-height: {{data.title_line_height}};<# } #>">{{data.title_text}}</div><# } #>
            <div class="wpremark-content" style="
            <# if (data.text_align && data.text_align != 'no') { #>text-align: {{data.text_align}};<# } #>
            <# if (data.text_color) { #>color: {{data.text_color}};<# } #>
            <# if (data.text_bold == true) { #>font-weight: bold; <# } #>
            <# if (data.text_italic == true) { #>font-style: italic; <# } #>
            <# if (data.text_underline == true) { #>text-decoration: underline; <# } #>
            <# if (data.text_uppercase == true) { #>text-transform: uppercase; <# } #>
            <# if (data.text_font_size) { #>font-size: {{data.text_font_size}}px;<# } #>
            <# if (data.text_line_height) { #>line-height: {{data.text_line_height}};<# } #>">
            <# if (data.innercontent != '') #>{{{ wpremarkPreviewHelper.nl2br(data.innercontent) }}} <# else #><?php echo __( 'Enter text...', Plugin::TEXT_DOMAIN ) ?></div>
        </div>
    </{{data.tag}}>
</script>