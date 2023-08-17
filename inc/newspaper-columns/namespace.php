<?php
/**
 * Figuren_Theater Site_Editing Newspaper_Columns.
 *
 * @package figuren-theater/ft-site-editing
 */

namespace Figuren_Theater\Site_Editing\Newspaper_Columns;

use Figuren_Theater\Site_Editing;

use FT_VENDOR_DIR;

use function add_action;
use function is_network_admin;
use function is_user_admin;
use WPMU_PLUGIN_URL;

const BASENAME   = 'newspaper-columns/newspaper-columns.php';
const PLUGINPATH = '/wpackagist-plugin/' . BASENAME;

/**
 * Bootstrap module, when enabled.
 *
 * @return void
 */
function bootstrap() :void {

	// Even the Plugin normally starts up at 'init:10',
	// we want to hook into 'after_setup_theme' which runs before 'init'.
	add_action( 'plugins_loaded', __NAMESPACE__ . '\\load_plugin' );
}

/**
 * Conditionally load the plugin itself and its modifications.
 *
 * @return void
 */
function load_plugin() :void {

	// Do only load in "normal" admin view
	// and for public views
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
		'handle' => 'newspaper-columns-fix',
		'src'    => WPMU_PLUGIN_URL . Site_Editing\ASSETS_URL . 'newspaper-columns/fix.css',
	];

	// Add "path" to allow inlining asset if the theme opts-in.
	$args['path'] = Site_Editing\DIRECTORY . 'assets/newspaper-columns/fix.css';

	// Enqueue asset.
	wp_enqueue_block_style( 'fortepress/newspaper-columns', $args );
}
