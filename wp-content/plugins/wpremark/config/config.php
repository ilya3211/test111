<?php

if ( ! defined( 'WPINC' ) ) {
	die;
}

use Wpshop\WPRemark\SettingsProvider;

return [
	'plugin_config'      => [
		'verify_url' => 'https://wpshop.ru/api.php',
		'update'     => [
			'url'          => 'https://api.wpgenerator.ru/wp-update-server/?action=get_metadata&slug=wpremark',
			'slug'         => 'wpremark',
			'check_period' => 12,
			'opt_name'     => 'wpremark-check-update',
		],
	],
	'settings_providers' => [
		SettingsProvider::class,
	],
];
