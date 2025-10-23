<?php

if ( ! defined( 'WPINC' ) ) {
    die;
}

use Wpshop\WPRemark\AdminMenu;
use Wpshop\WPRemark\Blockquotes;
use Wpshop\WPRemark\McePluginHelper;
use Wpshop\WPRemark\Templates;
use Wpshop\WPRemark\WPRemark;
use Wpshop\WPRemark\Plugin;
use Wpshop\WPRemark\Settings\BlockquoteOptions;
use Wpshop\WPRemark\Settings\PluginOptions;
use Pimple\Container;
use Wpshop\WPRemark\SettingsProvider;
use Wpshop\WPRemark\Preset;
use Wpshop\WPRemark\Shortcodes;
use Wpshop\WPRemark\Styles;
use Wpshop\SettingApi\SettingsManagerProvider;

return function ( $config ) {
    global $wpdb;

    $container = new Container( [
        'config'                 => $config,
        Plugin::class            => function ( $c ) {
            return new Plugin( $c['config']['plugin_config'], $c[ PluginOptions::class ] );
        },
        WPRemark::class          => function ( $c ) {
            return new WPRemark(
                $c[ Plugin::class ],
                $c[ PluginOptions::class ]
            );
        },
        PluginOptions::class     => function () {
            return new PluginOptions();
        },
        BlockquoteOptions::class => function () {
            return new BlockquoteOptions();
        },
        SettingsProvider::class  => function ( $c ) {
            return new SettingsProvider(
                $c[ Plugin::class ],
                $c[ PluginOptions::class ],
                $c[ BlockquoteOptions::class ]
            );
        },
        Blockquotes::class       => function ( $c ) {
            return new Blockquotes( $c[ BlockquoteOptions::class ] );
        },
        Shortcodes::class        => function ( $c ) {
            return new Shortcodes(
                $c[ Plugin::class ]
            //$c['config']['icons']
            );
        },
        Styles::class            => function ( $c ) {
            return new Styles(
                $c[ Plugin::class ]
            );
        },
        McePluginHelper::class   => function ( $c ) {
            return new McePluginHelper();
        },
        Preset::class            => function () use ( $wpdb ) {
            return new Preset( $wpdb );
        },
        AdminMenu::class         => function () {
            return new AdminMenu();
        },
        Templates::class         => function ( $c ) {
            return new Templates( $c[ WPRemark::class ] );
        },
    ] );

    if ( class_exists( SettingsManagerProvider::class ) ) {
        $container->register( new SettingsManagerProvider() );
    }

    return $container;
};
