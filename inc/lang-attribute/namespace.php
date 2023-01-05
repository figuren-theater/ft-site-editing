<?php
/**
 * Figuren_Theater Site_Editing Lang_Attribute.
 *
 * @package figuren-theater/site_editing/lang_attribute
 */

namespace Figuren_Theater\Site_Editing\Lang_Attribute;

use FT_VENDOR_DIR;

use function add_action;
use function is_admin;
use function is_network_admin;
use function is_user_admin;

const BASENAME   = 'lang-attribute/lang-attribute.php';
const PLUGINPATH = FT_VENDOR_DIR . '/wpackagist-plugin/' . BASENAME;

/**
 * Bootstrap module, when enabled.
 */
function bootstrap() {

	add_action( 'init', __NAMESPACE__ . '\\load_plugin', 9 );
}

function load_plugin() {

	// Do only load in "normal" admin view
	// Not for:
	// - public views
	// - network-admin views
	// - user-admin views
	if ( ! is_admin() || is_network_admin() || is_user_admin() )
		return;
	
	require_once PLUGINPATH;
}
