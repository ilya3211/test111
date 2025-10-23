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
global $wpshop_social;

$social_buttons = apply_filters( THEME_SLUG . '_social_share_buttons', array(
    'vkontakte', 'facebook', 'telegram', 'odnoklassniki', 'twitter',
    'sms', 'viber', 'whatsapp',

//    'moimir',
//    'linkedin',
//    'tumblr',
//    'surfingbird',
//    'pinterest',
//    'reddit',
//    'stumbleupon',
//    'pocket',
//    'xing',
//    'livejournal',
//    'evernote',
//    'delicious',
//    'blogger',
//    'wordpress',
//    'skype',
//    'line',
) );

$share_buttons = $wpshop_core->get_option( 'share_buttons' );
$share_buttons = explode( ',', $share_buttons );

echo '<div class="social-buttons">';
$wpshop_social->share_buttons( $share_buttons, array( 'show_label' => false, 'show_counters' => $wpshop_core->get_option( 'share_buttons_counters' ) ) );
echo '</div>';