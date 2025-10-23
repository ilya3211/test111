<?php

defined( 'WPINC' ) || die;

/**
 * @return bool
 */
function is_rss_for_yandex_turbo_enabled() {
	return in_array(
		'rss-for-yandex-turbo/rss-for-yandex-turbo.php',
		apply_filters( 'active_plugins', get_option( 'active_plugins' ) )
	);
}

$is_rss_for_yandex_turbo_page = false;

/**
 * @return void
 */
function init_support__rss_for_yandex_turbo() {
	global $is_rss_for_yandex_turbo_page;
	if ( is_rss_for_yandex_turbo_enabled() ) {
		$yturbo_options = get_option( 'yturbo_options' );
		if ( has_filter( 'do_feed_' . $yturbo_options['ytrssname'] ) ) {
			$is_rss_for_yandex_turbo_page = true;
			add_filter( 'yturbo_the_content', '_recipe_after_text', 0 );
			add_filter( 'yturbo_the_content', 'add_microdata_turbo', 0 );
		}
	}
}

add_action( 'init', 'init_support__rss_for_yandex_turbo', 11 );


function add_microdata_turbo( $content ) {
	return '<div itemscope itemtype="http://schema.org/Recipe">' . $content . '</div>';
}