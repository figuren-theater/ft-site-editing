<?php
/**
 * Figuren_Theater Site_Editing Block_Visibility.
 *
 * @package figuren-theater/ft-site-editing
 */

namespace Figuren_Theater\Site_Editing\Block_Visibility;

use Figuren_Theater;

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
function bootstrap() :void {

	add_action( 'plugins_loaded', __NAMESPACE__ . '\\load_plugin', 9 );
}

/**
 * Conditionally load the plugin itself and its modifications.
 *
 * @return void
 */
function load_plugin() :void {

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
 * Show the admin-menu, only:
 * - to super-administrators
 *
 * @return void
 */
function remove_menu() :void {
	if ( current_user_can( 'manage_sites' ) ) {
		return;
	}
	remove_action( 'admin_menu', 'BlockVisibility\\Admin\\add_settings_page' );
}
