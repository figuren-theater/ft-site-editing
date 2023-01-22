<?php
/**
 * Figuren_Theater Site_Editing Cbstdsys_Post_Subtitle.
 *
 * @package figuren-theater/site_editing/cbstdsys_post_subtitle
 */

namespace Figuren_Theater\Site_Editing\Cbstdsys_Post_Subtitle;

use FT_VENDOR_DIR;

use function add_action;
use function is_network_admin;
use function is_user_admin;

const BASENAME   = 'cbstdsys-post-subtitle/cbstdsys-post-subtitle.php';
const PLUGINPATH = FT_VENDOR_DIR . '/carstingaxion/' . BASENAME;

/**
 * Bootstrap module, when enabled.
 */
function bootstrap() {

	add_action( 'plugins_loaded', __NAMESPACE__ . '\\load_plugin', 9 );
}

function load_plugin() {

	// Do only load in "normal" admin view
	// and public views.
	// Not for:
	// - network-admin views
	// - user-admin views
	if ( is_network_admin() || is_user_admin() )
		return;
	
	require_once PLUGINPATH;
}
