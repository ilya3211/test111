<?php

/**
 * WPRemark
 *
 * @wordpress-plugin
 * Plugin Name:       WPRemark
 * Plugin URI:        https://wpshop.ru/plugins/wpremark
 * Description:       Plugin helps to add custom blockquotes on your site.
 * Version:           1.1.0
 * Author:            WPShop.ru
 * Author URI:        https://wpshop.ru/
 * License:           WPShop License
 * License URI:       https://wpshop.ru/license
 * Text Domain:       wpremark
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

use Wpshop\WPRemark\AdminMenu;
use Wpshop\WPRemark\Styles;
use Wpshop\WPRemark\Templates;
use Wpshop\WPRemark\WPRemark;
use Wpshop\WPRemark\Blockquotes;
use Wpshop\WPRemark\McePluginHelper;
use Wpshop\WPRemark\Plugin;
use Wpshop\WPRemark\PluginContainer;
use Wpshop\WPRemark\Preset;
use Wpshop\WPRemark\Shortcodes;
use Wpshop\SettingApi\SettingsManager;

require __DIR__ . '/vendor/autoload.php';

PluginContainer::get( McePluginHelper::class )->init();
PluginContainer::get( Plugin::class )->init( __FILE__ );
PluginContainer::get( AdminMenu::class )->init( __FILE__ );
PluginContainer::get( Blockquotes::class )->init();

//if ( PluginContainer::has( SettingsManager::class ) ) {
//	PluginContainer::get( SettingsManager::class )->init();
//}

PluginContainer::get( WPRemark::class )->init();
PluginContainer::get( Preset::class )->init();
PluginContainer::get( Templates::class )->init();
PluginContainer::get( Shortcodes::class )->init();
PluginContainer::get( Styles::class )->init();

register_activation_hook( __FILE__, 'wpremark_activate' );
register_deactivation_hook( __FILE__, 'wpremark_deactivate' );
register_uninstall_hook( __FILE__, 'wpremark_uninstall' );
