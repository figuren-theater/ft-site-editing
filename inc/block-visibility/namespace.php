<?php
/**
 * Figuren_Theater Site_Editing Block_Visibility.
 *
 * @package figuren-theater/site_editing/block_visibility
 */

namespace Figuren_Theater\Site_Editing\Block_Visibility;

use FT_VENDOR_DIR;

use Figuren_Theater;
use function Figuren_Theater\get_config;

use function add_action;
use function current_user_can;
use function is_network_admin;
use function is_user_admin;
use function remove_action;

const BASENAME   = 'block-visibility/block-visibility.php';
const PLUGINPATH = FT_VENDOR_DIR . '/wpackagist-plugin/' . BASENAME;

/**
 * Bootstrap module, when enabled.
 */
function bootstrap() {

	add_action( 'plugins_loaded', __NAMESPACE__ . '\\load_plugin', 9 );
}

function load_plugin() {

	$config = Figuren_Theater\get_config()['modules']['site_editing'];
	if ( ! $config['block-visibility'] )
		return; // early

	// Do only load in "normal" admin view
	// and public views
	// Not for:
	// - network-admin views
	// - user-admin views
	if ( is_network_admin() || is_user_admin() )
		return;
	
	require_once PLUGINPATH;
	
	// 'plugins_loaded' is too early for 'current_user_can()'
	// add_action( 'plugins_loaded', __NAMESPACE__ . '\\post_load_plugin', 11 );
	add_action( 'admin_menu', __NAMESPACE__ . '\\post_load_plugin', 0 );

}

function post_load_plugin() {
	if ( current_user_can( 'manage_sites' ) ) {
		return;
	}
	remove_action( 'admin_menu', 'BlockVisibility\\Admin\\add_settings_page' );
}
