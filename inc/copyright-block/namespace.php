<?php
/**
 * Figuren_Theater Site_Editing Copyright_Block.
 *
 * @package figuren-theater/ft-site-editing
 */

namespace Figuren_Theater\Site_Editing\Copyright_Block;

use Figuren_Theater;

use FT_VENDOR_DIR;
use function add_action;
use function add_filter;
use function is_network_admin;
use function is_user_admin;

const BASENAME   = 'copyright-block/copyright-block.php';
const PLUGINPATH = '/wpackagist-plugin/' . BASENAME;

const BLOCKTYPE = 'mkaz/copyright-block';

/**
 * Bootstrap module, when enabled.
 *
 * @return void
 */
function bootstrap(): void {

	add_action( 'init', __NAMESPACE__ . '\\load_plugin', 9 );
}

/**
 * Conditionally load the plugin itself and its modifications.
 *
 * @return void
 */
function load_plugin(): void {

	$config = Figuren_Theater\get_config()['modules']['site_editing'];
	if ( ! $config['copyright-block'] ) {
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

	add_filter( 'register_block_type_args', __NAMESPACE__ . '\\modify_block_args', 10, 2 );
}

/**
 * Attach a custom render function for the existing 'copyright-block'.
 *
 * @param array<string, mixed> $args       Normal block.json arguments.
 * @param string               $block_type Slug of the block being filtered.
 *
 * @return array<string, mixed>
 */
function modify_block_args( array $args, string $block_type ): array {

	if ( BLOCKTYPE !== $block_type ) {
		return $args;
	}

	$args['render_callback'] = __NAMESPACE__ . '\\modify_block_output';
	return $args;
}

/**
 * Return a copyright mark followed by the current year.
 *
 * @return string
 */
function modify_block_output(): string {
	$year = gmdate( 'Y' );
	return '© ' . $year;
}
