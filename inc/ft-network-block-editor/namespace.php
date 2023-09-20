<?php
/**
 * Figuren_Theater Site_Editing FT_Network_Block_Editor.
 *
 * @package figuren-theater/ft-site-editing
 */

namespace Figuren_Theater\Site_Editing\FT_Network_Block_Editor;

use FT_VENDOR_DIR;

use function add_action;
use function is_network_admin;
use function is_user_admin;

const BASENAME   = 'ft-network-block-editor/plugin.php';
const PLUGINPATH = '/figuren-theater/' . BASENAME;

/**
 * Bootstrap module, when enabled.
 *
 * @return void
 */
function bootstrap() {

	add_action( 'init', __NAMESPACE__ . '\\load_plugin', 9 );
}

/**
 * Conditionally load the plugin itself and its modifications.
 *
 * @return void
 */
function load_plugin() :void {

	// Do only load in "normal" admin view
	// Not for:
	// - public views
	// - network-admin views
	// - user-admin views.
	if ( is_network_admin() || is_user_admin() ) {
		return;
	}

	require_once FT_VENDOR_DIR . PLUGINPATH; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant
}
