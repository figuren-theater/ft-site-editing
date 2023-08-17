<?php
/**
 * Figuren_Theater Site_Editing Embed_Block_For_Github.
 *
 * @package figuren-theater/ft-site-editing
 */

namespace Figuren_Theater\Site_Editing\Embed_Block_For_Github;

use Figuren_Theater;
use Figuren_Theater\Site_Editing;

use FT_VENDOR_DIR;
use function add_action;
use function is_network_admin;
use function is_user_admin;
use WPMU_PLUGIN_URL;

const BASENAME   = 'embed-block-for-github/embed-block-for-github.php';
const PLUGINPATH = '/wpackagist-plugin/' . BASENAME;

/**
 * Bootstrap module, when enabled.
 *
 * @return void
 */
function bootstrap() :void {

	add_action( 'init', __NAMESPACE__ . '\\load_plugin', 9 );
}

/**
 * Conditionally load the plugin itself and its modifications.
 *
 * @return void
 */
function load_plugin() :void {

	$config = Figuren_Theater\get_config()['modules']['site_editing'];
	if ( ! $config['embed-block-for-github'] ) {
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

	add_action( 'after_setup_theme', __NAMESPACE__ . '\\enqueue_css_fix' );
}

/**
 * Enqueue minimal CSS fix
 *
 * @return void
 */
function enqueue_css_fix() :void {
	// Same args used for wp_enqueue_style().
	$args = [
		'handle' => 'ebg-repository',
		'src'    => WPMU_PLUGIN_URL . Site_Editing\ASSETS_URL . 'embed-block-for-github/fix.css',
	];

	// Add "path" to allow inlining asset if the theme opts-in.
	$args['path'] = Site_Editing\DIRECTORY . 'assets/embed-block-for-github/fix.css';

	// Enqueue asset.
	wp_enqueue_block_style( 'embed-block-for-github/repository', $args );
}

