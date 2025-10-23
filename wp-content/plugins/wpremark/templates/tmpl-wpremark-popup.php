<?php

if ( ! defined( 'WPINC' ) ) {
    die;
}

use Wpshop\WPRemark\Plugin;
use Wpshop\WPRemark\Templates;
use Wpshop\WPRemark\Icons;
use Wpshop\WPRemark\PluginContainer;
use Wpshop\WPRemark\Preset;

$class_templates = PluginContainer::get( Templates::class );
$class_icons = new Icons();
$icon_images = $class_icons->get_icons();

$presets = PluginContainer::get( Preset::class )->get_all_preses();
$preset_names = [];
$preset_data = [];

foreach ( $presets as $preset ) {
    $preset_names[] = $preset['name'];
    $preset_data[] = $preset['data'];
}

?>

<script type="text/javascript">
    var __wpremark_preset_items = <?php echo json_encode( $preset_names ) ?>;
    var __wpremark_preset_data = <?php echo json_encode( $preset_data ) ?>;

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
        }
    };
</script>

<script type="text/html" id="tmpl-wpremark-popup">
    <div class="mce-wpremark">
        <div class="mce-wpremark-presets js-mce-wpremark-presets">
            <?php foreach ( $class_templates->get_templates( true, true ) as $template ) : ?>
                <span class="mce-wpremark-preset js-mce-wpremark-preset" data-name="<?php echo $template['preset_name'] ?>" data-styles="<?php echo esc_attr( json_encode( $template ) ) ?>">
                    <?php
                        $icon = '';

                        if ( $template['icon_show'] ) {
                            $preset_icon_styles = '';

                            if ( $template['icon_position'] == 'left top' || $template['icon_position'] == 'left center' || $template['icon_position'] == 'left bottom' ) $preset_icon_styles .= 'margin-right: 5px;';
//                            if ( $template['icon_position'] == 'top left' || $template['icon_position'] == 'top center' || $template['icon_position'] == 'top right' ) $preset_icon_styles .= 'margin-bottom: 5px;';
                            if ( $template['icon_position'] == 'right top' || $template['icon_position'] == 'right center' || $template['icon_position'] == 'right bottom' ) $preset_icon_styles .= 'order: 10; margin-left: 5px;';
                            if ( $template['icon_position'] == 'bottom left' || $template['icon_position'] == 'bottom center' || $template['icon_position'] == 'bottom right' ) $preset_icon_styles .= 'order: 10; margin-top: 5px;';
                            if ( $template['icon_position'] == 'left center' || $template['icon_position'] == 'right center' || $template['icon_position'] == 'top center' || $template['icon_position'] == 'bottom center' ) $preset_icon_styles .= 'align-self: center;';
                            if ( $template['icon_position'] == 'left top' || $template['icon_position'] == 'right top') $preset_icon_styles .= 'align-self: flex-start;';
                            if ( $template['icon_position'] == 'left bottom' || $template['icon_position'] == 'right bottom' || $template['icon_position'] == 'top right' || $template['icon_position'] == 'bottom right') $preset_icon_styles .= 'align-self: flex-end;';

                            $icon .= '<span class="mce-wpremark-preset-icon" style="' . $preset_icon_styles . '">';

                            if ( empty( $template['icon_image_custom'] ) ) {
                                $icon_styles = [];

                                if ( $template['icon_color'] ) {
                                    $icon_styles[] = 'color : ' . $template['icon_color'];
                                }

                                $icon .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="' . $icon_images[$template['icon_image']]['path'] . '" fill="currentColor" style="' . implode( ';', $icon_styles ) . '"/></svg>';
                            } else {
                                $icon .= '<img src="' + $template['icon_image_custom'] + '">';
                            }

                            $icon .= '</span>';
                        }

                        $styles = [];
                        $text_styles = [];

                        if ( $template['icon_show'] && ( $template['icon_position'] == 'top left' || $template['icon_position'] == 'top center' || $template['icon_position'] == 'top right' || $template['icon_position'] == 'bottom left' || $template['icon_position'] == 'bottom center' || $template['icon_position'] == 'bottom right' ) ) $styles[] = 'flex-direction: column';
                        if ( $template['background_show'] && ! empty( $template['background_color'] ) ) $styles[] = 'background-color: ' . $template['background_color'];
                        if ( $template['background_show'] && ! empty( $template['background_image'] ) ) $styles[] = 'background-image: url(' . $template['background_image'] . ')';
                        if ( $template['background_show'] && ! empty( $template['background_image_repeat'] ) ) $styles[] = 'background-repeat: ' . $template['background_image_repeat'];
                        if ( $template['background_show'] && ! empty( $template['background_image_position'] ) ) $styles[] = 'background-position: ' . $template['background_image_position'];
                        if ( $template['background_show'] && ! empty( $template['background_image_size'] ) ) $styles[] = 'background-size: ' . $template['background_image_size'];
                        if ( $template['border_radius'] ) $styles[] = 'border-radius: ' . $template['border_radius'] . 'px';
                        if ( $template['border_top'] ) $styles[] = 'border-top: ' . $template['border_width'] . ' ' . $template['border_style'] . ' ' . $template['border_color'];
                        if ( $template['border_right'] ) $styles[] = 'border-right: ' . $template['border_width'] . ' ' . $template['border_style'] . ' ' . $template['border_color'];
                        if ( $template['border_bottom'] ) $styles[] = 'border-bottom: ' . $template['border_width'] . ' ' . $template['border_style'] . ' ' . $template['border_color'];
                        if ( $template['border_left'] ) $styles[] = 'border-left: ' . $template['border_width'] . ' ' . $template['border_style'] . ' ' . $template['border_color'];
                        if ( $template['shadow_show'] ) {
                            $shadow_x = ( ! empty( $template['shadow_x'] ) ) ? $template['shadow_x'] : 0;
                            $shadow_y = ( ! empty( $template['shadow_y'] ) ) ? $template['shadow_y'] : 0;
                            $shadow_blur = ( ! empty( $template['shadow_blur'] ) ) ? $template['shadow_blur'] : 0;
                            $shadow_stretching = ( ! empty( $template['shadow_stretching'] ) ) ? $template['shadow_stretching'] : 0;
                            $shadow_color = ( ! empty( $template['shadow_color'] ) ) ? $template['shadow_color'] : '#000000';
                            list($r, $g, $b) = sscanf($shadow_color, "#%02x%02x%02x");
                            $shadow_opacity = ( ! empty( $template['shadow_opacity'] ) ) ? $template['shadow_opacity'] : '0.5';
                            $styles[] = 'box-shadow: ' . $shadow_x . 'px ' . $shadow_y . 'px ' . $shadow_blur . 'px ' . $shadow_stretching . 'px rgba(' . $r . ',' . $g . ',' . $b . ',' . $shadow_opacity . ')';
                        }
                        if ( ! empty( $template['text_color'] ) ) $text_styles[] = 'color: ' . $template['text_color'];
                        if ( $template['text_bold'] ) $text_styles[] = 'font-weight: bold';
                        if ( $template['text_italic'] ) $text_styles[] = 'font-style: italic';
                        if ( $template['text_underline'] ) $text_styles[] = 'text-decoration: underline';
                        if ( $template['text_uppercase'] ) $text_styles[] = 'text-transform: uppercase';
                    ?>
                    <span class="mce-wpremark-block-preview" style="<?php echo implode( ';', $styles ) ?>">
                        <?php echo $icon ?>
                        <span class="mce-wpremark-preset-body" style="<?php echo implode( ';', $text_styles ) ?>"><?php echo __( 'Text', Plugin::TEXT_DOMAIN ) ?></span>
                    </span>
                </span>
            <?php endforeach; ?>

            <# for (var i = 0; i < __wpremark_preset_items.length; i++) { #>
                <span class="mce-wpremark-preset js-mce-wpremark-preset-custom" data-name="{{__wpremark_preset_items[i]}}">
                    <span class="mce-wpremark-block-preview" style="
                    <# if (__wpremark_preset_data[i]['icon_show'] == true && (__wpremark_preset_data[i]['icon_position'] == 'top left' || __wpremark_preset_data[i]['icon_position'] == 'top center' || __wpremark_preset_data[i]['icon_position'] == 'top right' || __wpremark_preset_data[i]['icon_position'] == 'bottom left' || __wpremark_preset_data[i]['icon_position'] == 'bottom center' || __wpremark_preset_data[i]['icon_position'] == 'bottom right')) { #>flex-direction: column;<# } #>
                    <# if (__wpremark_preset_data[i]['background_show'] == true && __wpremark_preset_data[i]['background_color']) { #>background-color: {{__wpremark_preset_data[i]['background_color']}};<# } #>
                    <# if (__wpremark_preset_data[i]['background_show'] == true && __wpremark_preset_data[i]['background_image']) { #>background-image: url({{__wpremark_preset_data[i]['background_image']}}); background-size: cover;<# } #>
                    <# if (__wpremark_preset_data[i]['border_top'] == true) { #>border-top: {{__wpremark_preset_data[i]['border_width']}}px {{__wpremark_preset_data[i]['border_style']}} {{__wpremark_preset_data[i]['border_color']}};<# } #>
                    <# if (__wpremark_preset_data[i]['border_right'] == true) { #>border-right: {{__wpremark_preset_data[i]['border_width']}}px {{__wpremark_preset_data[i]['border_style']}} {{__wpremark_preset_data[i]['border_color']}};<# } #>
                    <# if (__wpremark_preset_data[i]['border_bottom'] == true) { #>border-bottom: {{__wpremark_preset_data[i]['border_width']}}px {{__wpremark_preset_data[i]['border_style']}} {{__wpremark_preset_data[i]['border_color']}};<# } #>
                    <# if (__wpremark_preset_data[i]['border_left'] == true) { #>border-left: {{__wpremark_preset_data[i]['border_width']}}px {{__wpremark_preset_data[i]['border_style']}} {{__wpremark_preset_data[i]['border_color']}};<# } #>
                    <# if (__wpremark_preset_data[i]['shadow_show'] == true) { #>box-shadow: {{__wpremark_preset_data[i]['shadow_x']}}px {{__wpremark_preset_data[i]['shadow_y']}}px {{__wpremark_preset_data[i]['shadow_blur']}}px {{__wpremark_preset_data[i]['shadow_stretching']}}px rgba({{{ wpremarkPreviewHelper.shadow_color(__wpremark_preset_data[i]['shadow_color']) }}},{{__wpremark_preset_data[i]['shadow_opacity']}});<# } #>">
                        <# if (__wpremark_preset_data[i]['icon_show'] == true) { #>
                            <span class="mce-wpremark-preset-icon" style="
                            <# if (__wpremark_preset_data[i]['icon_position'] === 'left top' || __wpremark_preset_data[i]['icon_position'] === 'left center' || __wpremark_preset_data[i]['icon_position'] === 'left bottom') { #>margin-right: 5px;<# } #>
                            /*<# if (__wpremark_preset_data[i]['icon_position'] === 'top left' || __wpremark_preset_data[i]['icon_position'] === 'top center' || __wpremark_preset_data[i]['icon_position'] === 'top right') { #>margin-bottom: 5px;<# } #>*/
                            <# if (__wpremark_preset_data[i]['icon_position'] === 'right top' || __wpremark_preset_data[i]['icon_position'] === 'right center' || __wpremark_preset_data[i]['icon_position'] === 'right bottom') { #>order: 10; margin-left: 5px;<# } #>
                            <# if (__wpremark_preset_data[i]['icon_position'] === 'bottom left' || __wpremark_preset_data[i]['icon_position'] === 'bottom center' || __wpremark_preset_data[i]['icon_position'] === 'bottom right') { #>order: 10; margin-top: 5px;<# } #>
                            <# if (__wpremark_preset_data[i]['icon_position'] === 'left center' || __wpremark_preset_data[i]['icon_position'] === 'right center' || __wpremark_preset_data[i]['icon_position'] === 'top center' || __wpremark_preset_data[i]['icon_position'] === 'bottom center') { #>align-self: center;<# } #>
                            <# if (__wpremark_preset_data[i]['icon_position'] === 'left top' || __wpremark_preset_data[i]['icon_position'] === 'right top') { #>align-self: flex-start;<# } #>
                            <# if (__wpremark_preset_data[i]['icon_position'] === 'left bottom' || __wpremark_preset_data[i]['icon_position'] === 'right bottom' || __wpremark_preset_data[i]['icon_position'] === 'top right' || __wpremark_preset_data[i]['icon_position'] === 'bottom right') { #>align-self: flex-end;<# } #>">
                                <# if (! __wpremark_preset_data[i]['icon_image_custom']) { #>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="{{{ wpremarkPreviewHelper.icon(__wpremark_preset_data[i]['icon_image']) }}}" fill="currentColor" style="
                                    <# if (__wpremark_preset_data[i]['icon_color']) { #>color: {{__wpremark_preset_data[i]['icon_color']}}; <# } #>"/></svg>
                                <# } else { #>
                                    <img src="{{__wpremark_preset_data[i]['icon_image_custom']}}">
                                <# } #>
                            </span>
                        <# } #>
                        <span class="mce-wpremark-preset-body" style="
                        <# if (__wpremark_preset_data[i]['text_color']) { #>color: {{__wpremark_preset_data[i]['text_color']}};<# } #>
                        <# if (__wpremark_preset_data[i]['text_bold'] == true) { #>font-weight: bold;<# } #>
                        <# if (__wpremark_preset_data[i]['text_italic'] == true) { #>font-style: italic;<# } #>
                        <# if (__wpremark_preset_data[i]['text_underline'] == true) { #>text-decoration: underline;<# } #>
                        <# if (__wpremark_preset_data[i]['text_uppercase'] == true) { #>text-transform: uppercase;<# } #>">
                        <?php echo __( 'Text', Plugin::TEXT_DOMAIN ) ?></span>
                    </span>
                    <span class="mce-wpremark-preset-update js-mce-wpremark-preset-update"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="<?php echo $icon_images['file-text-regular']['path'] ?>" fill="currentColor"/></svg></span>
                    <span class="mce-wpremark-preset-remove js-mce-wpremark-preset-remove"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="<?php echo $icon_images['times-regular']['path'] ?>" fill="currentColor"/></svg></span>
                </span>
            <# } #>

            <?php /*
            <span class="mce-wpremark-preset mce-wpremark-preset-save js-mce-wpremark-preset-save">
                <span class="mce-wpremark-block-preview"><?php echo __( 'Create preset', Plugin::TEXT_DOMAIN ) ?></span>
            </span>
 */ ?>

            <input name="preset_name" type="hidden" value="{{data.preset_name}}">
        </div>

        <div class="mce-wpremark-textarea">
            <# if (typeof data.innercontent === 'string') {
                data.innercontent = data.innercontent.replace(/<p>/g, '\n');
                data.innercontent = data.innercontent.replace(/<\/p>/g, '');
                data.innercontent = data.innercontent.replace(/<br>/g, '');
                data.innercontent = data.innercontent.replace(/<\/br>/g, '');
                data.innercontent = data.innercontent.replace(/<br \/>/g, '');
            } #>
            <textarea name="text" placeholder="<?php echo __( 'Enter text...', Plugin::TEXT_DOMAIN ) ?>">{{data.innercontent}}</textarea>
        </div>

        <div class="mce-wpremark-box js-mce-wpremark-box">
            <div class="mce-wpremark-header js-mce-wpremark-header">
                <input name="icon_show" type="checkbox"<# if (data.icon_show == true) { #> checked<# } #>><?php echo __( 'Icon', Plugin::TEXT_DOMAIN ) ?>
            </div>

            <div class="mce-wpremark-form">
                <label class="mce-wpremark-form-label"><?php echo __( 'Select icon', Plugin::TEXT_DOMAIN ) ?></label>
                <div class="mce-wpremark-form-field">
                    <input type="text" id="wpremark-icon-search" placeholder="<?php echo __( 'Search icon', Plugin::TEXT_DOMAIN ) ?>">
                    <div class="mce-wpremark-icon-images js-wpremark-icon-images">
                        <?php foreach ( $class_icons->get_icons() as $icon_name => $icon ) :
                            if ( ! isset( $icon['keywords'] ) ) $icon['keywords'] = [];
                            echo '<span class="mce-wpremark-icon-image js-mce-wpremark-icon-image" data-type="' . $icon_name . '" data-keywords="' . implode(',', $icon['keywords']) . '">' . $class_icons->get_icon( $icon_name ) . '</span>';
                        endforeach; ?>
                    </div>
                </div>
            </div>

            <input name="icon_image" type="hidden" value="{{data.icon_image}}">

            <div class="mce-wpremark-form">
                <label class="mce-wpremark-form-label" for="mce-wpremark-icon-image-custom"><?php echo __( 'Own picture (url)', Plugin::TEXT_DOMAIN ) ?></label>
                <div class="mce-wpremark-form-field">
                    <input name="icon_image_custom" id="mce-wpremark-icon-image-custom" type="text" value="{{data.icon_image_custom}}">
<!--                    <p class="description">--><?php //echo __( 'By default, displayed the preset icon.<br>If you set an arbitrary picture, it will be displayed as an icon', Plugin::TEXT_DOMAIN ) ?><!--</p>-->
                </div>
            </div>

            <div class="mce-wpremark-form">
                <label class="mce-wpremark-form-label" for="mce-wpremark-icon-color"><?php echo __( 'Color', Plugin::TEXT_DOMAIN ) ?></label>
                <div class="mce-wpremark-form-field">
                    <input name="icon_color" id="mce-wpremark-icon-color" type="text" class="js-wpshop-color-picker" value="{{data.icon_color}}">
                </div>
            </div>

            <div class="mce-wpremark-form">
                <label class="mce-wpremark-form-label"><?php echo __( 'Size, px', Plugin::TEXT_DOMAIN ) ?></label>
                <div class="mce-wpremark-form-field">
                    <div class="mce-wpremark-form">
                        <input name="icon_width" type="number" value="{{data.icon_width}}">
                        <input name="icon_height" type="number" value="{{data.icon_height}}">
                    </div>
                </div>
            </div>

            <div class="mce-wpremark-form">
                <label class="mce-wpremark-form-label"><?php echo __( 'Indent, px', Plugin::TEXT_DOMAIN ) ?></label>
                <div class="mce-wpremark-form-field">
                    <div class="mce-wpremark-form">
                        <input name="icon_indent" type="number" value="{{data.icon_indent}}">
                    </div>
                </div>
            </div>

            <div class="mce-wpremark-form">
                <label class="mce-wpremark-form-label"><?php echo __( 'Position', Plugin::TEXT_DOMAIN ) ?></label>
                <div class="mce-wpremark-form-field">
                    <select name="icon_position">
                        <option value="left top"
                        <# if (data.icon_position == "left top") { #> selected<# } #>><?php echo __( 'Left top', Plugin::TEXT_DOMAIN ) ?></option>
                        <option value="left center"
                        <# if (data.icon_position == "left center") { #> selected<# } #>><?php echo __( 'Left center', Plugin::TEXT_DOMAIN ) ?></option>
                        <option value="left bottom"
                        <# if (data.icon_position == "left bottom") { #> selected<# } #>><?php echo __( 'Left bottom', Plugin::TEXT_DOMAIN ) ?></option>

                        <option value="top left"
                        <# if (data.icon_position == "top left") { #> selected<# } #>><?php echo __( 'Top left', Plugin::TEXT_DOMAIN ) ?></option>
                        <option value="top center"
                        <# if (data.icon_position == "top center") { #> selected<# } #>><?php echo __( 'Top center', Plugin::TEXT_DOMAIN ) ?></option>
                        <option value="top right"
                        <# if (data.icon_position == "top right") { #> selected<# } #>><?php echo __( 'Top right', Plugin::TEXT_DOMAIN ) ?></option>

                        <option value="right top"
                        <# if (data.icon_position == "right top") { #> selected<# } #>><?php echo __( 'Right top', Plugin::TEXT_DOMAIN ) ?></option>
                        <option value="right center"
                        <# if (data.icon_position == "right center") { #> selected<# } #>><?php echo __( 'Right center', Plugin::TEXT_DOMAIN ) ?></option>
                        <option value="right bottom"
                        <# if (data.icon_position == "right bottom") { #> selected<# } #>><?php echo __( 'Right bottom', Plugin::TEXT_DOMAIN ) ?></option>

                        <option value="bottom left"
                        <# if (data.icon_position == "bottom left") { #> selected<# } #>><?php echo __( 'Bottom left', Plugin::TEXT_DOMAIN ) ?></option>
                        <option value="bottom center"
                        <# if (data.icon_position == "bottom center") { #> selected<# } #>><?php echo __( 'Bottom center', Plugin::TEXT_DOMAIN ) ?></option>
                        <option value="bottom right"
                        <# if (data.icon_position == "bottom right") { #> selected<# } #>><?php echo __( 'Bottom right', Plugin::TEXT_DOMAIN ) ?></option>
                    </select>
                </div>
            </div>
        </div>

        <div class="mce-wpremark-box js-mce-wpremark-box">
            <div class="mce-wpremark-header js-mce-wpremark-header">
                <input name="background_show" type="checkbox"<# if (data.background_show == true) { #> checked<# } #>><?php echo __( 'Background', Plugin::TEXT_DOMAIN ) ?>
            </div>

            <div class="mce-wpremark-form">
                <label class="mce-wpremark-form-label" for="mce-wpremark-background-color"><?php echo __( 'Сolor', Plugin::TEXT_DOMAIN ) ?></label>
                <div class="mce-wpremark-form-field">
                    <input name="background_color" id="mce-wpremark-background-color" type="text" class="js-wpshop-color-picker" value="{{data.background_color}}">
                </div>
            </div>

            <div class="mce-wpremark-form">
                <label class="mce-wpremark-form-label" for="mce-wpremark-background-image"><?php echo __( 'Picture', Plugin::TEXT_DOMAIN ) ?></label>
                <div class="mce-wpremark-form-field">
                    <input name="background_image" id="mce-wpremark-background-image" type="text" value="{{data.background_image}}">
                </div>
            </div>

            <div class="mce-wpremark-form">
                <label class="mce-wpremark-form-label"><?php echo __( 'Repeat', Plugin::TEXT_DOMAIN ) ?></label>
                <div class="mce-wpremark-form-field">
                    <select name="background_image_repeat">
                        <option value="no-repeat"
                        <# if (data.background_image_repeat == "no-repeat") { #> selected<# } #>><?php echo __( 'No repeat', Plugin::TEXT_DOMAIN ) ?></option>
                        <option value="repeat"
                        <# if (data.background_image_repeat == "repeat") { #> selected<# } #>><?php echo __( 'Repeat horizontal and vertical', Plugin::TEXT_DOMAIN ) ?></option>
                        <option value="repeat-x"
                        <# if (data.background_image_repeat == "repeat-x") { #> selected<# } #>><?php echo __( 'Repeat horizontal', Plugin::TEXT_DOMAIN ) ?></option>
                        <option value="repeat-y"
                        <# if (data.background_image_repeat == "repeat-y") { #> selected<# } #>><?php echo __( 'Repeat verticals', Plugin::TEXT_DOMAIN ) ?></option>
                    </select>
                </div>
            </div>

            <div class="mce-wpremark-form">
                <label class="mce-wpremark-form-label"><?php echo __( 'Position', Plugin::TEXT_DOMAIN ) ?></label>
                <div class="mce-wpremark-form-field">
                    <select name="background_image_position">
                        <option value="left top"
                        <# if (data.background_image_position == "top left") { #> selected<# } #>><?php echo __( 'Top left', Plugin::TEXT_DOMAIN ) ?></option>
                        <option value="center top"
                        <# if (data.background_image_position == "top center") { #> selected<# } #>><?php echo __( 'Top center', Plugin::TEXT_DOMAIN ) ?></option>
                        <option value="right top"
                        <# if (data.background_image_position == "top right") { #> selected<# } #>><?php echo __( 'Top right', Plugin::TEXT_DOMAIN ) ?></option>
                        <option value="left center"
                        <# if (data.background_image_position == "left center") { #> selected<# } #>><?php echo __( 'Middle left', Plugin::TEXT_DOMAIN ) ?></option>
                        <option value="center center"
                        <# if (data.background_image_position == "center center") { #> selected<# } #>><?php echo __( 'Middle center', Plugin::TEXT_DOMAIN ) ?></option>
                        <option value="right center"
                        <# if (data.background_image_position == "right center") { #> selected<# } #>><?php echo __( 'Middle right', Plugin::TEXT_DOMAIN ) ?></option>
                        <option value="left bottom"
                        <# if (data.background_image_position == "bottom left") { #> selected<# } #>><?php echo __( 'Bottom left', Plugin::TEXT_DOMAIN ) ?></option>
                        <option value="center bottom"
                        <# if (data.background_image_position == "bottom center") { #> selected<# } #>><?php echo __( 'Bottom center', Plugin::TEXT_DOMAIN ) ?></option>
                        <option value="right bottom"
                        <# if (data.background_image_position == "right bottom") { #> selected<# } #>><?php echo __( 'Bottom right', Plugin::TEXT_DOMAIN ) ?></option>
                    </select>
                </div>
            </div>

            <div class="mce-wpremark-form">
                <label class="mce-wpremark-form-label"><?php echo __( 'Size', Plugin::TEXT_DOMAIN ) ?></label>
                <div class="mce-wpremark-form-field">
                    <select name="background_image_size">
                        <option value="auto"
                        <# if (data.background_image_size == "auto") { #> selected<# } #>><?php echo __( 'Auto', Plugin::TEXT_DOMAIN ) ?></option>
                        <option value="cover"
                        <# if (data.background_image_size == "cover") { #> selected<# } #>><?php echo __( 'Cover', Plugin::TEXT_DOMAIN ) ?></option>
                        <option value="contain"
                        <# if (data.background_image_size == "contain") { #> selected<# } #>><?php echo __( 'Contain', Plugin::TEXT_DOMAIN ) ?></option>
                    </select>
                </div>
            </div>
        </div>

        <div class="mce-wpremark-box js-mce-wpremark-box">
            <div class="mce-wpremark-header js-mce-wpremark-header">
                <?php echo __( 'Border', Plugin::TEXT_DOMAIN ) ?>
            </div>

            <div class="mce-wpremark-form">
                <div class="mce-wpremark-form-label"><?php echo __( 'Show border', Plugin::TEXT_DOMAIN ) ?></div>
                <div class="mce-wpremark-form-field">
                    <div>
                        <input name="border_top" type="checkbox"<# if (data.border_top == true) { #> checked<# } #>><?php echo __( 'Top', Plugin::TEXT_DOMAIN ) ?>
                    </div>
                    <div>
                        <input name="border_right" type="checkbox"<# if (data.border_right == true) { #> checked<# } #>><?php echo __( 'Right', Plugin::TEXT_DOMAIN ) ?>
                    </div>
                    <div>
                        <input name="border_bottom" type="checkbox"<# if (data.border_bottom == true) { #> checked<# } #>><?php echo __( 'Bottom', Plugin::TEXT_DOMAIN ) ?>
                    </div>
                    <div>
                        <input name="border_left" type="checkbox"<# if (data.border_left == true) { #> checked<# } #>><?php echo __( 'Left', Plugin::TEXT_DOMAIN ) ?>
                    </div>
                </div>
            </div>

            <div class="mce-wpremark-form">
                <label class="mce-wpremark-form-label"><?php echo __( 'Thickness and style', Plugin::TEXT_DOMAIN ) ?></label>
                <div class="mce-wpremark-form-field">
                    <div class="mce-wpremark-form">
                        <input name="border_width" type="number" value="{{data.border_width}}">
                        <select name="border_style">
                            <option value="dotted"
                            <# if (data.border_style == "dotted") { #> selected<# } #>><?php echo __( 'Dotted', Plugin::TEXT_DOMAIN ) ?></option>
                            <option value="dashed"
                            <# if (data.border_style == "dashed") { #> selected<# } #>><?php echo __( 'Dashed', Plugin::TEXT_DOMAIN ) ?></option>
                            <option value="solid"
                            <# if (data.border_style == "solid") { #> selected<# } #>><?php echo __( 'Solid', Plugin::TEXT_DOMAIN ) ?></option>
                            <option value="double"
                            <# if (data.border_style == "double") { #> selected<# } #>><?php echo __( 'Double', Plugin::TEXT_DOMAIN ) ?></option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mce-wpremark-form">
                <label class="mce-wpremark-form-label" for="mce-wpremark-border-color"><?php echo __( 'Color', Plugin::TEXT_DOMAIN ) ?></label>
                <div class="mce-wpremark-form-field">
                    <input name="border_color" id="mce-wpremark-border-color" type="text" class="js-wpshop-color-picker" value="{{data.border_color}}">
                </div>
            </div>
        </div>

        <div class="mce-wpremark-box js-mce-wpremark-box">
            <div class="mce-wpremark-header js-mce-wpremark-header">
                <input name="shadow_show" type="checkbox"<# if (data.shadow_show == true) { #> checked<# } #>><?php echo __( 'Shadow', Plugin::TEXT_DOMAIN ) ?>
            </div>

            <div class="mce-wpremark-form">
                <label class="mce-wpremark-form-label"><?php echo __( 'Shift on X and Y, px', Plugin::TEXT_DOMAIN ) ?></label>
                <div class="mce-wpremark-form-field">
                    <div class="mce-wpremark-form">
                        <input name="shadow_x" type="number" value="{{data.shadow_x}}">
                        <input name="shadow_y" type="number" value="{{data.shadow_y}}">
                    </div>
<!--                    <p class="description">--><?php //echo __( 'A positive value shifts the shadow to the right,<br>a negative value to the left', Plugin::TEXT_DOMAIN ) ?><!--</p>-->
                </div>
            </div>

            <div class="mce-wpremark-form">
                <label class="mce-wpremark-form-label"><?php echo __( 'Blurring and stretching, px', Plugin::TEXT_DOMAIN ) ?></label>
                <div class="mce-wpremark-form-field">
                    <div class="mce-wpremark-form">
                        <input name="shadow_blur" type="number" value="{{data.shadow_blur}}">
                        <input name="shadow_stretching" type="number" value="{{data.shadow_stretching}}">
                    </div>
<!--                    <p class="description">--><?php //echo __( 'A positive value shifts the shadow to the right,<br>a negative value to the left', Plugin::TEXT_DOMAIN ) ?><!--</p>-->
                </div>
            </div>

            <div class="mce-wpremark-form">
                <label class="mce-wpremark-form-label" for="mce-wpremark-shadow-color"><?php echo __( 'Color', Plugin::TEXT_DOMAIN ) ?></label>
                <div class="mce-wpremark-form-field">
                    <input name="shadow_color" id="mce-wpremark-shadow-color" type="text" class="js-wpshop-color-picker" value="{{data.shadow_color}}">
                </div>
            </div>

            <div class="mce-wpremark-form">
                <label class="mce-wpremark-form-label"><?php echo __( 'Opacity', Plugin::TEXT_DOMAIN ) ?></label>
                <div class="mce-wpremark-form-field">
                    <div class="mce-wpremark-form">
                        <input name="shadow_opacity" type="number" min="0" max="1" step="0.1" value="{{data.shadow_opacity}}">
                    </div>
                </div>
            </div>
        </div>

        <div class="mce-wpremark-box js-mce-wpremark-box">
            <div class="mce-wpremark-header js-mce-wpremark-header">
                <input name="title_show" type="checkbox"<# if (data.title_show == true) { #> checked<# } #>><?php echo __( 'Title', Plugin::TEXT_DOMAIN ) ?>
            </div>

            <div class="mce-wpremark-form">
                <label class="mce-wpremark-form-label" for="mce-wpremark-title-text"><?php echo __( 'Title', Plugin::TEXT_DOMAIN ) ?></label>
                <div class="mce-wpremark-form-field">
                    <input name="title_text" id="mce-wpremark-title-text" type="text" value="{{data.title_text}}">
                </div>
            </div>

            <div class="mce-wpremark-form">
                <label class="mce-wpremark-form-label"><?php echo __( 'Align', Plugin::TEXT_DOMAIN ) ?></label>
                <div class="mce-wpremark-form-field">
                    <select name="title_align">
                        <option value="no"
                        <# if (data.title_align == "no") { #> selected<# } #>><?php echo __( 'Not set', Plugin::TEXT_DOMAIN ) ?></option>
                        <option value="left"
                        <# if (data.title_align == "left") { #> selected<# } #>><?php echo __( 'Left', Plugin::TEXT_DOMAIN ) ?></option>
                        <option value="center"
                        <# if (data.title_align == "center") { #> selected<# } #>><?php echo __( 'Center', Plugin::TEXT_DOMAIN ) ?></option>
                        <option value="right"
                        <# if (data.title_align == "right") { #> selected<# } #>><?php echo __( 'Right', Plugin::TEXT_DOMAIN ) ?></option>
                        <option value="justify"
                        <# if (data.title_align == "justify") { #> selected<# } #>><?php echo __( 'By width', Plugin::TEXT_DOMAIN ) ?></option>
                    </select>
                </div>
            </div>

            <div class="mce-wpremark-form">
                <label class="mce-wpremark-form-label" for="mce-wpremark-title-color"><?php echo __( 'Color', Plugin::TEXT_DOMAIN ) ?></label>
                <div class="mce-wpremark-form-field">
                    <input name="title_color" id="mce-wpremark-title-color" type="text" class="js-wpshop-color-picker" value="{{data.title_color}}">
                </div>
            </div>

            <div class="mce-wpremark-form">
                <div class="mce-wpremark-form-label"><?php echo __( 'Style', Plugin::TEXT_DOMAIN ) ?></div>
                <div class="mce-wpremark-form-field">
                    <div>
                        <input name="title_bold" type="checkbox"<# if (data.title_bold == true) { #> checked<# } #>><?php echo __( 'Bold', Plugin::TEXT_DOMAIN ) ?>
                    </div>
                    <div>
                        <input name="title_italic" type="checkbox"<# if (data.title_italic == true) { #> checked<# } #>><?php echo __( 'Italic', Plugin::TEXT_DOMAIN ) ?>
                    </div>
                    <div>
                        <input name="title_underline" type="checkbox"<# if (data.title_underline == true) { #> checked<# } #>><?php echo __( 'Underlined', Plugin::TEXT_DOMAIN ) ?>
                    </div>
                    <div>
                        <input name="title_uppercase" type="checkbox"<# if (data.title_uppercase == true) { #> checked<# } #>><?php echo __( 'Uppercase', Plugin::TEXT_DOMAIN ) ?>
                    </div>
                </div>
            </div>

            <div class="mce-wpremark-form">
                <label class="mce-wpremark-form-label" for="mce-wpremark-title-font-size"><?php echo __( 'Font size, px', Plugin::TEXT_DOMAIN ) ?></label>
                <div class="mce-wpremark-form-field">
                    <input name="title_font_size" id="mce-wpremark-title-font-size" type="number" value="{{data.title_font_size}}">
                </div>
            </div>

            <div class="mce-wpremark-form">
                <label class="mce-wpremark-form-label" for="mce-wpremark-title-line-height"><?php echo __( 'Line height', Plugin::TEXT_DOMAIN ) ?></label>
                <div class="mce-wpremark-form-field">
                    <input name="title_line_height" id="mce-wpremark-title-line-height" type="number" step="0.1" value="{{data.title_line_height}}">
                </div>
            </div>
        </div>

        <div class="mce-wpremark-box js-mce-wpremark-box">
            <div class="mce-wpremark-header js-mce-wpremark-header"><?php echo __( 'Text', Plugin::TEXT_DOMAIN ) ?></div>

            <div class="mce-wpremark-form">
                <label class="mce-wpremark-form-label"><?php echo __( 'Align', Plugin::TEXT_DOMAIN ) ?></label>
                <div class="mce-wpremark-form-field">
                    <select name="text_align">
                        <option value="no"
                        <# if (data.text_align == "no") { #> selected<# } #>><?php echo __( 'Not set', Plugin::TEXT_DOMAIN ) ?></option>
                        <option value="left"
                        <# if (data.text_align == "left") { #> selected<# } #>><?php echo __( 'Left', Plugin::TEXT_DOMAIN ) ?></option>
                        <option value="center"
                        <# if (data.text_align == "center") { #> selected<# } #>><?php echo __( 'Center', Plugin::TEXT_DOMAIN ) ?></option>
                        <option value="right"
                        <# if (data.text_align == "right") { #> selected<# } #>><?php echo __( 'Right', Plugin::TEXT_DOMAIN ) ?></option>
                        <option value="justify"
                        <# if (data.text_align == "justify") { #> selected<# } #>><?php echo __( 'By width', Plugin::TEXT_DOMAIN ) ?></option>
                    </select>
                </div>
            </div>

            <div class="mce-wpremark-form">
                <label class="mce-wpremark-form-label" for="mce-wpremark-text-color"><?php echo __( 'Text color', Plugin::TEXT_DOMAIN ) ?></label>
                <div class="mce-wpremark-form-field">
                    <input name="text_color" id="mce-wpremark-text-color" type="text" class="js-wpshop-color-picker" value="{{data.text_color}}">
                </div>
            </div>

            <div class="mce-wpremark-form">
                <label class="mce-wpremark-form-label" for="mce-wpremark-link-color"><?php echo __( 'Link color', Plugin::TEXT_DOMAIN ) ?></label>
                <div class="mce-wpremark-form-field">
                    <input name="text_link_color" id="mce-wpremark-link-color" type="text" class="js-wpshop-color-picker" value="{{data.text_link_color}}">
                </div>
            </div>

            <div class="mce-wpremark-form">
                <div class="mce-wpremark-form-label"><?php echo __( 'Style', Plugin::TEXT_DOMAIN ) ?></div>
                <div class="mce-wpremark-form-field">
                    <div>
                        <input name="text_bold" type="checkbox"<# if (data.text_bold == true) { #> checked<# } #>><?php echo __( 'Bold', Plugin::TEXT_DOMAIN ) ?>
                    </div>
                    <div>
                        <input name="text_italic" type="checkbox"<# if (data.text_italic == true) { #> checked<# } #>><?php echo __( 'Italic', Plugin::TEXT_DOMAIN ) ?>
                    </div>
                    <div>
                        <input name="text_underline" type="checkbox"<# if (data.text_underline == true) { #> checked<# } #>><?php echo __( 'Underlined', Plugin::TEXT_DOMAIN ) ?>
                    </div>
                    <div>
                        <input name="text_uppercase" type="checkbox"<# if (data.text_uppercase == true) { #> checked<# } #>><?php echo __( 'Uppercase', Plugin::TEXT_DOMAIN ) ?>
                    </div>
                </div>
            </div>

            <div class="mce-wpremark-form">
                <label class="mce-wpremark-form-label" for="mce-wpremark-text-font-size"><?php echo __( 'Font size, px', Plugin::TEXT_DOMAIN ) ?></label>
                <div class="mce-wpremark-form-field">
                    <input name="text_font_size" id="mce-wpremark-text-font-size" type="number" value="{{data.text_font_size}}">
                </div>
            </div>

            <div class="mce-wpremark-form">
                <label class="mce-wpremark-form-label" for="mce-wpremark-text-line-height"><?php echo __( 'Line height', Plugin::TEXT_DOMAIN ) ?></label>
                <div class="mce-wpremark-form-field">
                    <input name="text_line_height" id="mce-wpremark-text-line-height" type="number" step="0.1" value="{{data.text_line_height}}">
                </div>
            </div>
        </div>

        <div class="mce-wpremark-box js-mce-wpremark-box">
            <div class="mce-wpremark-header js-mce-wpremark-header"><?php echo __( 'Advanced settings', Plugin::TEXT_DOMAIN ) ?></div>
                <div class="mce-wpremark-form">
                    <label class="mce-wpremark-form-label"><?php echo __( 'Inner padding', Plugin::TEXT_DOMAIN ) ?></label>
                    <div class="mce-wpremark-form-field">
                        <div class="mce-wpremark-form">
                            <input name="padding_top" type="number" value="{{data.padding_top}}">
                            <input name="padding_right" type="number" value="{{data.padding_right}}">
                            <input name="padding_bottom" type="number" value="{{data.padding_bottom}}">
                            <input name="padding_left" type="number" value="{{data.padding_left}}">
                        </div>
                        <p class="description"><?php echo __( 'Top, right, bottom and left', Plugin::TEXT_DOMAIN ) ?></p>
                    </div>
                </div>

                <div class="mce-wpremark-form">
                    <label class="mce-wpremark-form-label"><?php echo __( 'External indent', Plugin::TEXT_DOMAIN ) ?></label>
                    <div class="mce-wpremark-form-field">
                        <div class="mce-wpremark-form">
                            <input name="margin_top" type="number" value="{{data.margin_top}}">
                            <input name="margin_right" type="number" value="{{data.margin_right}}">
                            <input name="margin_bottom" type="number" value="{{data.margin_bottom}}">
                            <input name="margin_left" type="number" value="{{data.margin_left}}">
                        </div>
                        <p class="description"><?php echo __( 'Top, right, bottom and left', Plugin::TEXT_DOMAIN ) ?></p>
                    </div>
                </div>

                <div class="mce-wpremark-form">
                    <div class="mce-wpremark-form-label" for="mce-wpremark-border-radius"><?php echo __( 'Rounding corners', Plugin::TEXT_DOMAIN ) ?></div>
                    <div class="mce-wpremark-form-field">
                        <input name="border_radius" id="mce-wpremark-border-radius" type="number" value="{{data.border_radius}}">
                    </div>
                </div>

                <div class="mce-wpremark-form">
                    <label class="mce-wpremark-form-label"><?php echo __( 'Tag', Plugin::TEXT_DOMAIN ) ?></label>
                    <div class="mce-wpremark-form-field">
                        <select name="tag">
                            <option value="div"
                            <# if (data.tag == "div") { #> selected<# } #>>div</option>
                            <option value="blockquote"
                            <# if (data.tag == "blockquote") { #> selected<# } #>>blockquote</option>
                        </select>
                    </div>
                </div>

                <div class="mce-wpremark-form">
                    <label class="mce-wpremark-form-label"><?php echo __( 'Styles output', Plugin::TEXT_DOMAIN ) ?></label>
                    <div class="mce-wpremark-form-field">
                        <select name="css">
                            <option value="head"
                            <# if (data.css == "head") { #> selected<# } #>><?php echo __( 'In &lt;head&gt;', Plugin::TEXT_DOMAIN ) ?></option>
                            <option value="near"
                            <# if (data.css == "near") { #> selected<# } #>><?php echo __( 'Near the block', Plugin::TEXT_DOMAIN ) ?></option>
                        </select>
                    </div>
                </div>

                <div class="mce-wpremark-form">
                    <div class="mce-wpremark-form-label" for="mce-wpremark-custom-class"><?php echo __( 'Additional class', Plugin::TEXT_DOMAIN ) ?></div>
                    <div class="mce-wpremark-form-field">
                        <input name="custom_class" id="mce-wpremark-custom-class" type="text" value="{{data.custom_class}}">
                    </div>
                </div>

                <input name="block_id" id="mce-wpremark-block-id" type="hidden" value="{{data.block_id}}">
            </div>
        </div>
</script>
