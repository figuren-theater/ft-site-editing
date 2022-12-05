<?php
/**
 * Figuren_Theater Site_Editing Newspaper_Columns.
 *
 * @package figuren-theater/site_editing/newspaper_columns
 */

namespace Figuren_Theater\Site_Editing\Newspaper_Columns;

use FT_VENDOR_DIR;

use function add_action;
use function is_network_admin;
use function is_user_admin;

const BASENAME   = 'newspaper-columns/newspaper-columns.php';
const PLUGINPATH = FT_VENDOR_DIR . '/wpackagist-plugin/' . BASENAME;

/**
 * Bootstrap module, when enabled.
 */
function bootstrap() {

	add_action( 'init', __NAMESPACE__ . '\\load_plugin', 9 );
}

function load_plugin() {

	// Do only load in "normal" admin view
	// and for public views
	// Not for:
	// - network-admin views
	// - user-admin views
	if ( is_network_admin() || is_user_admin() )
		return;
	
	require_once PLUGINPATH;
}
