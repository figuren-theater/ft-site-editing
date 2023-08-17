<?php
/**
 * Figuren_Theater Site_Editing Dinosaur_Game.
 *
 * @package figuren-theater/ft-site-editing
 */

namespace Figuren_Theater\Site_Editing\Dinosaur_Game;

use Figuren_Theater;

use FT_VENDOR_DIR;
use function add_action;
use function is_network_admin;
use function is_user_admin;

const BASENAME   = 'dinosaur-game/dinosaur-game.php';
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
	if ( ! $config['dinosaur-game'] ) {
		return;
	}

	// Do only load in "normal" admin view
	// and for public views
	// Not for:
	// - network-admin views
	// - user-admin views.
	if ( is_network_admin() || is_user_admin() ) {
		return;
	}

	require_once FT_VENDOR_DIR . PLUGINPATH; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant

	add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\remove_scripts', 0 );
}

/**
 * Prevent the enqueueing of any dino-related CSS & JS,
 * if the current request is not resulting in error 404.
 *
 * @return void
 */
function remove_scripts() :void {
	is_404() || remove_action( 'wp_enqueue_scripts', 'dinogame_js_css' );
}
