<?php
/**
 * ****************************************************************************
 *
 *   НЕ РЕДАКТИРУЙТЕ ЭТОТ ФАЙЛ
 *   DON'T EDIT THIS FILE
 *
 * *****************************************************************************
 *
 * @package cook-it
 */


function wpshop_enqueue_plugin_scripts( $plugin_array ) {
    //enqueue TinyMCE plugin script with its ID.
    $plugin_array['blockquote_button_plugin'] =  get_template_directory_uri() . '/assets/js/tinymce.min.js';
    return $plugin_array;
}

add_filter( 'mce_external_plugins', 'wpshop_enqueue_plugin_scripts' );




function wpshop_register_buttons_editor( $buttons ) {
    //register buttons with their id.
    array_push(
        $buttons,
        'blockquote_btn',
        'spoiler_btn',
        'mark_btn',
        'mask_link'
    );
    return $buttons;
}
add_filter( 'mce_buttons_3', 'wpshop_register_buttons_editor' );