<?php
/**
 * Figuren_Theater Site_Editing Todo_Block.
 *
 * @package figuren-theater/site_editing\todo_block
 */

namespace Figuren_Theater\Site_Editing\Todo_Block;

use FT_VENDOR_DIR;

use Figuren_Theater;
use function Figuren_Theater\get_config;

use function add_action;
use function register_block_style;
use function wp_unique_id;

const BASENAME   = 'todo-block/todo-block.php';
const PLUGINPATH = FT_VENDOR_DIR . '/wpackagist-plugin/' . BASENAME;

/**
 * Bootstrap module, when enabled.
 */
function bootstrap() {

	add_action( 'plugins_loaded', __NAMESPACE__ . '\\load_plugin' );
}

function load_plugin() {

	$config = Figuren_Theater\get_config()['modules']['site_editing'];
	if ( ! $config['todo-block'] )
		return; // early

	require_once PLUGINPATH;

	add_action( 'init', __NAMESPACE__ . '\\rbs' );

	add_action( 'todolists_add_checkbox', __NAMESPACE__ . '\\a11y_todo_items', 10, 3 );
}


function rbs() : void {

	if ( function_exists( 'register_block_style' ) ) {
		register_block_style(
			'pluginette/todo-block-list',
			[
				'name'         => 'ft-todo',
				'label'        => __( 'Todo list', 'figurentheater' ),
				'is_default'   => true,
				'inline_style' => '.is-style-ft-todo input { transform: scale(1.5); } .is-style-ft-todo > div {align-items: baseline;}',
			]
		);
	}
}

function a11y_todo_items( string $content, string $block_content, bool $checked ) : string {

	$_prefix = 'ft_todo_';

	$_block_class = 'wp-block-pluginette-todo-block-item';

	// create unique id to properly connect input and label
	$_id = wp_unique_id( $_prefix );

	// add unique id to input
	$_search  = 'type="checkbox"';
	$_replace = 'type="checkbox" id="' . $_id . '"';
	$content  = str_replace( $_search, $_replace, $content );

	// replace div with label (on default items)
	$_search  = 'div class="' . $_block_class . '"';
	$_replace = 'label class="' . $_block_class . '" for="' . $_id . '"';
	$content  = str_replace( $_search, $_replace, $content );

	// replace div with label (on items with custom classes)
	$_search  = 'div class="' . $_block_class . ' '; // the empty space is important
	$_replace = 'label for="' . $_id . '" class="' . $_block_class . ' '; // the empty space is important
	$content  = str_replace( $_search, $_replace, $content );

	$_search  = "/div>\n</div>";
	$_replace = '/label></div>';
	$content  = str_replace( $_search, $_replace, $content );
	
	return $content;
}

