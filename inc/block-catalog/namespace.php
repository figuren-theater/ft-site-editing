<?php
/**
 * Figuren_Theater Site_Editing Block_Catalog.
 *
 * @package figuren-theater/ft-site-editing
 */

namespace Figuren_Theater\Site_Editing\Block_Catalog;

use Figuren_Theater;

use FT_VENDOR_DIR;
use function add_action;
use function is_admin;
use function is_network_admin;
use function is_user_admin;

const BASENAME   = 'block-catalog/block-catalog.php';
const PLUGINPATH = '/wpackagist-plugin/' . BASENAME;

/**
 * Bootstrap module, when enabled.
 *
 * @return void
 */
function bootstrap(): void {

	add_action( 'init', __NAMESPACE__ . '\\load_plugin', 9 );
}

/**
 * Conditionally load the plugin itself and its modifications.
 *
 * @return void
 */
function load_plugin(): void {

	$config = Figuren_Theater\get_config()['modules']['site_editing'];
	if ( ! $config['block-catalog'] ) {
		return;
	}

	// Do only load in "normal" admin view
	// Not for:
	// - public views
	// - network-admin views
	// - user-admin views.
	if ( ! is_admin() || is_network_admin() || is_user_admin() ) {
		return;
	}

	require_once FT_VENDOR_DIR . PLUGINPATH; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant
}
