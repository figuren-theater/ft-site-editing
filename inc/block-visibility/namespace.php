<?php
/**
 * Figuren_Theater Site_Editing Block_Visibility.
 *
 * @package figuren-theater/ft-site-editing
 */

namespace Figuren_Theater\Site_Editing\Block_Visibility;

use Figuren_Theater;
use Figuren_Theater\Options;
use FT_VENDOR_DIR;
use function add_action;
use function current_user_can;
use function is_network_admin;
use function is_user_admin;
use function remove_action;

const BASENAME   = 'block-visibility/block-visibility.php';
const PLUGINPATH = '/wpackagist-plugin/' . BASENAME;

/**
 * Bootstrap module, when enabled.
 *
 * @return void
 */
function bootstrap(): void {

	add_action( 'Figuren_Theater\loaded', __NAMESPACE__ . '\\filter_options', 11 );

	add_action( 'plugins_loaded', __NAMESPACE__ . '\\load_plugin', 9 );
}

/**
 * Conditionally load the plugin itself and its modifications.
 *
 * @return void
 */
function load_plugin(): void {

	$config = Figuren_Theater\get_config()['modules']['site_editing'];
	if ( ! $config['block-visibility'] ) {
		return;
	}

	// Do only load in "normal" admin view
	// and public views
	// Not for:
	// - network-admin views
	// - user-admin views.
	if ( is_network_admin() || is_user_admin() ) {
		return;
	}

	require_once FT_VENDOR_DIR . PLUGINPATH; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant

	add_action( 'admin_menu', __NAMESPACE__ . '\\remove_menu', 0 );
}

/**
 * Handle options
 *
 * @return void
 */
function filter_options(): void {

	$_options = [
		'block_visibility_settings' => [ // The options name in the DB.
			'visibility_controls' => array(
				'browser_device'     => array(
					'enable' => false,
				),
				'cookie'             => array(
					'enable' => false,
				),
				'date_time'          => array(
					'enable'             => true,
					'enable_day_of_week' => true,
					'enable_time_of_day' => true,
					'enable_scheduling'  => true,
				),
				'hide_block'         => array(
					'enable' => true,
				),
				'location'           => array(
					'enable' => false,
				),
				'metadata'           => array(
					'enable' => false,
				),
				'query_string'       => array(
					'enable' => false,
				),
				'referral_source'    => array(
					'enable' => false,
				),
				'screen_size'        => array(
					'enable'                   => true,
					'breakpoints'              => array(
						'extra_large' => '1200px',
						'large'       => '992px',
						'medium'      => '768px',
						'small'       => '576px',
					),
					'controls'                 => array(
						'extra_large' => true,
						'large'       => true,
						'medium'      => true,
						'small'       => true,
						'extra_small' => true,
					),
					'enable_advanced_controls' => false,
					'enable_frontend_css'      => true,
				),
				'url_path'           => array(
					'enable' => false,
				),
				'visibility_by_role' => array(
					'enable'                => false,
					'enable_user_roles'     => true,
					'enable_users'          => true,
					'enable_user_rule_sets' => true,
				),
				'visibility_presets' => array(
					'enable' => false,
				),
				'acf'                => array(
					'enable' => false,
				),
				'woocommerce'        => array(
					'enable'                  => false,
					'enable_variable_pricing' => true,
				),
				'edd'                => array(
					'enable'                  => false,
					'enable_variable_pricing' => true,
				),
				'wp_fusion'          => array(
					'enable' => false,
				),
				'general'            => array(
					'enable_local_controls' => true,
				),
			),
			'disabled_blocks'     => array(),
			'plugin_settings'     => array(
				'default_controls'              => array(
				),
				'enable_contextual_indicators'  => true,
				'contextual_indicator_color'    => '',
				'enable_block_opacity'          => true,
				'block_opacity'                 => 70,
				'enable_toolbar_controls'       => true,
				'enable_editor_notices'         => true,
				'enable_user_role_restrictions' => true,
				'enabled_user_roles'            => array(
					0 => 'editor',
				),
				'enable_full_control_mode'      => false,
				'remove_on_uninstall'           => false,
				'enable_control_set_utilities'  => false,
			),
		],
	];

	/*
	 * Gets added to the 'OptionsCollection'
	 * from within itself on creation.
	 */
	new Options\Factory(
		$_options,
		'Figuren_Theater\Options\Option',
		BASENAME,
	);
}

/**
 * Show the admin-menu, only:
 * - to super-administrators
 *
 * @return void
 */
function remove_menu(): void {
	if ( current_user_can( 'manage_sites' ) ) {
		return;
	}
	remove_action( 'admin_menu', 'BlockVisibility\\Admin\\add_settings_page' );
}
