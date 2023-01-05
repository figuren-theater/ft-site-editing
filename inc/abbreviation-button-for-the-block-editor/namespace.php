<?php
/**
 * Figuren_Theater Site_Editing Abbreviation_Button_For_The_Block_Editor.
 *
 * @package figuren-theater/site_editing/abbreviation_button_for_the_block_editor
 */

namespace Figuren_Theater\Site_Editing\Abbreviation_Button_For_The_Block_Editor;

use FT_VENDOR_DIR;

use function add_action;
use function is_admin;
use function is_network_admin;
use function is_user_admin;

const BASENAME   = 'abbreviation-button-for-the-block-editor/abbreviation-button-for-the-block-editor.php';
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
