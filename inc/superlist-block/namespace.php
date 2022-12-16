<?php
/**
 * Figuren_Theater Site_Editing Superlist_Block.
 *
 * @package figuren-theater/site_editing/superlist_block
 */

namespace Figuren_Theater\Site_Editing\Superlist_Block;

use FT_VENDOR_DIR;

use Figuren_Theater\Site_Editing;

use function add_action;
use function is_network_admin;
use function is_user_admin;
use function wp_enqueue_block_style;

const BASENAME   = 'superlist-block/superlist-block.php';
const PLUGINPATH = FT_VENDOR_DIR . '/wpackagist-plugin/' . BASENAME;

/**
 * Bootstrap module, when enabled.
 */
function bootstrap() {

	// even the Plugin normally starts up at 'init:10', 
	// we want to hook into 'after_setup_theme' which runs before 'init'
	add_action( 'plugins_loaded', __NAMESPACE__ . '\\load_plugin' );
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
	
	add_action( 'after_setup_theme', __NAMESPACE__ . '\\enqueue_css_fix' );
}


function enqueue_css_fix() {
	// Same args used for wp_enqueue_style().
	$args = array(
		'handle' => 'superlist-block-fix',
		'src'    => Site_Editing\ASSETS_URL . 'superlist-block/fix.css',
	);

	// Add "path" to allow inlining asset if the theme opts-in.
	$args['path'] = Site_Editing\DIRECTORY . 'assets/superlist-block/fix.css';

	// Enqueue asset.
	wp_enqueue_block_style( 'createwithrani/superlist-block', $args );
}
