<?php

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

use Wpshop\WPRemark\PluginContainer;
use Wpshop\WPRemark\Settings\PluginOptions;

require __DIR__ . '/vendor/autoload.php';

PluginContainer::get( PluginOptions::class )->destroy();
