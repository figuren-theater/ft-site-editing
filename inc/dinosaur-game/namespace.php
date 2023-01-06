<?php
/**
 * Figuren_Theater Site_Editing Dinosaur_Game.
 *
 * @package figuren-theater/site_editing/dinosaur_game
 */

namespace Figuren_Theater\Site_Editing\Dinosaur_Game;

use FT_VENDOR_DIR;

use Figuren_Theater;
use function Figuren_Theater\get_config;

use function add_action;
use function is_network_admin;
use function is_user_admin;

const BASENAME   = 'dinosaur-game/dinosaur-game.php';
const PLUGINPATH = FT_VENDOR_DIR . '/wpackagist-plugin/' . BASENAME;

/**
 * Bootstrap module, when enabled.
 */
function bootstrap() {

	add_action( 'init', __NAMESPACE__ . '\\load_plugin', 9 );
}

function load_plugin() {

	$config = Figuren_Theater\get_config()['modules']['site_editing'];
	if ( ! $config['dinosaur-game'] )
		return; // early

	// Do only load in "normal" admin view
	// and for public views
	// Not for:
	// - network-admin views
	// - user-admin views
	if ( is_network_admin() || is_user_admin() )
		return;
	
	require_once PLUGINPATH;

	add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\remove_scripts', 0 );
}

function remove_scripts() {
	is_404() || remove_action( 'wp_enqueue_scripts', 'dinogame_js_css' );
}
