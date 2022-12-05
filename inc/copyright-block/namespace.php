<?php
/**
 * Figuren_Theater Site_Editing Copyright_Block.
 *
 * @package figuren-theater/site_editing/copyright_block
 */

namespace Figuren_Theater\Site_Editing\Copyright_Block;

use FT_VENDOR_DIR;

use Figuren_Theater;
use function Figuren_Theater\get_config;

use function add_action;
use function add_filter;
use function is_network_admin;
use function is_user_admin;

const BASENAME   = 'copyright-block/copyright-block.php';
const PLUGINPATH = FT_VENDOR_DIR . '/wpackagist-plugin/' . BASENAME;

const BLOCKTYPE  = 'mkaz/copyright-block';

/**
 * Bootstrap module, when enabled.
 */
function bootstrap() {

	add_action( 'init', __NAMESPACE__ . '\\load_plugin', 9 );
}

function load_plugin() {

	$config = Figuren_Theater\get_config()['modules']['site_editing'];
	if ( ! $config['copyright-block'] )
		return; // early

	// Do only load in "normal" admin view
	// and for public views
	// Not for:
	// - network-admin views
	// - user-admin views
	if ( is_network_admin() || is_user_admin() )
		return;
	
	require_once PLUGINPATH;

	add_filter( 'register_block_type_args', __NAMESPACE__ . '\\modify_block_args', 10, 2 );
}



function modify_block_args( array $args, string $block_type ) : array {

	if ( BLOCKTYPE !== $block_type )
		return $args;

	$args['render_callback'] = __NAMESPACE__ . '\\modify_block_output';
	return $args;
}

function modify_block_output() : string {
	$year = date('Y');
	return "© " . $year;
}
