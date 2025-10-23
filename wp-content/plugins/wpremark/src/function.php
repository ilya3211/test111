<?php

use Wpshop\WPRemark\Icons;
use Wpshop\WPRemark\Logger;
use Wpshop\WPRemark\PluginContainer;
use Wpshop\WPRemark\Settings\PluginOptions;

function wpremark_activate() {
	if ( PluginContainer::has( PluginOptions::class ) ) {
		$options = PluginContainer::get( PluginOptions::class );

		$options->error_log_level = Logger::DISABLED;

		$options->save( PluginOptions::MODE_ADD );
	}
}

function wpremark_deactivate() {

}

function wpremark_uninstall() {
	if ( PluginContainer::has( PluginOptions::class ) ) {
		PluginContainer::get( PluginOptions::class )->destroy();
	}
}

function wpremark_icon( $icon, $attrs = [] ) {
    $icons = new Icons();
    return $icons->get_icon( $icon, $attrs );
}
