<?php
/**
 * Figuren_Theater Site_Editing Todo_Block.
 *
 * @package figuren-theater/ft-site-editing
 */

namespace Figuren_Theater\Site_Editing\Todo_Block;

use Figuren_Theater;

use FT_VENDOR_DIR;
use function add_action;
use function add_filter;
use function register_block_style;
use function wp_unique_id;

const BASENAME   = 'todo-block/todo-block.php';
const PLUGINPATH = '/wpackagist-plugin/' . BASENAME;

/**
 * Bootstrap module, when enabled.
 *
 * @return void
 */
function bootstrap() :void {

	add_action( 'plugins_loaded', __NAMESPACE__ . '\\load_plugin' );
}

/**
 * Conditionally load the plugin itself and its modifications.
 *
 * @return void
 */
function load_plugin() :void {

	$config = Figuren_Theater\get_config()['modules']['site_editing'];
	if ( ! $config['todo-block'] ) {
		return;
	}

	require_once FT_VENDOR_DIR . PLUGINPATH; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant

	add_action( 'init', __NAMESPACE__ . '\\rbs' );

	add_filter( 'todolists_add_checkbox', __NAMESPACE__ . '\\a11y_todo_items', 10, 3 );
}

/**
 * Register a custom block style for the 'todo list' block.
 *
 * The new style will be the new default and has a slightly bigger checkmark.
 *
 * @return void
 */
function rbs() :void {

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

/**
 * Connect form fields with labels for better accesibility.
 *
 * @todo #55 Suggest a solution to 'Connect form fields with labels' to the plugin-author
 *
 * @param string $content       Rendered HTML content of a single todo-list item
 * @param string $block_content Full rendered block
 * @param boolean $checked      Is the list item checked or not?
 *
 * @return string               Modified HTML content of a single todo-list item
 */
function a11y_todo_items( string $content, string $block_content, bool $checked ) :string {

	$_prefix = 'ft_todo_';

	$_block_class = 'wp-block-pluginette-todo-block-item';

	// Create unique id to properly connect input and label.
	$_id = wp_unique_id( $_prefix );

	// Add unique id to input.
	$_search  = 'type="checkbox"';
	$_replace = 'type="checkbox" id="' . $_id . '"';
	$content  = str_replace( $_search, $_replace, $content );

	// Replace div with label (on default items).
	$_search  = 'div class="' . $_block_class . '"';
	$_replace = 'label class="' . $_block_class . '" for="' . $_id . '"';
	$content  = str_replace( $_search, $_replace, $content );

	// Replace div with label (on items with custom classes).
	$_search  = 'div class="' . $_block_class . ' '; // The empty space is important at the end !!
	$_replace = 'label for="' . $_id . '" class="' . $_block_class . ' '; // The empty space is important at the end !!
	$content  = str_replace( $_search, $_replace, $content );

	$_search  = "/div>\n</div>";
	$_replace = '/label></div>';
	$content  = str_replace( $_search, $_replace, $content );

	return $content;
}

