<?php
/**
 * Figuren_Theater Site_Editing Embed_Block_For_Github.
 *
 * @package figuren-theater/site_editing/embed_block_for_github
 */

namespace Figuren_Theater\Site_Editing\Embed_Block_For_Github;

use FT_VENDOR_DIR;

use function add_action;
use function is_admin;
use function is_network_admin;
use function is_user_admin;

const BASENAME   = 'embed-block-for-github/embed-block-for-github.php';
const PLUGINPATH = FT_VENDOR_DIR . '/wpackagist-plugin/' . BASENAME;

/**
 * Bootstrap module, when enabled.
 */
function bootstrap() {

	add_action( 'init', __NAMESPACE__ . '\\load_plugin', 9 );
}

function load_plugin() {

	$config = Figuren_Theater\get_config()['modules']['site_editing'];
	if ( ! $config['embed-block-for-github'] )
		return; // early

	// Do only load in "normal" admin view
	// and public views
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
		'handle' => 'ebg-repository',
		'src'    => Site_Editing\ASSETS_URL . 'embed-block-for-github/fix.css',
	);

	// Add "path" to allow inlining asset if the theme opts-in.
	$args['path'] = Site_Editing\DIRECTORY . 'assets/embed-block-for-github/fix.css';

	// Enqueue asset.
	wp_enqueue_block_style( 'embed-block-for-github/repository', $args );
}

