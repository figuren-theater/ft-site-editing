<?php
/**
 * Figuren_Theater Site_Editing Gallery_Block_Lightbox.
 *
 * @package figuren-theater/ft-site-editing
 */

namespace Figuren_Theater\Site_Editing\Gallery_Block_Lightbox;

use Figuren_Theater;

use FT_VENDOR_DIR;
use function add_action;
use function add_filter;

const BASENAME   = 'gallery-block-lightbox/gallery-block-lightbox.php';
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
	if ( ! $config['gallery-block-lightbox'] ) {
		return;
	}

	require_once FT_VENDOR_DIR . PLUGINPATH; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant

	add_filter( 'baguettebox_enqueue_assets', __NAMESPACE__ . '\\enqueue_assets' );
	/**
	 * Additional available filters:
	 *
	 * @example add_filter( 'baguettebox_selector', __NAMESPACE__ . '\\selector' );
	 * @example add_filter( 'baguettebox_filter', __NAMESPACE__ . '\\filter' );
	 */
}

/**
 * Filters whether baguettebox assets have to be enqueued.
 *
 * @since   Plugin 1.11
 *
 * @package project_name
 * @version version
 * @author  Carsten Bach
 *
 * @param   bool  $should_load_scripts  Whether baguettebox assets have to be enqueued.
 *
 * @return  bool                            [description]
 */
function enqueue_assets( bool $should_load_scripts ) :bool {
	return (
		\has_block( 'core/gallery' ) ||
		\has_block( 'core/image' ) ||
		\has_block( 'core/media-text' ) ||
		\get_post_gallery()
	);
}

/**
 * Filters the CSS selector of baguetteBox.js
 *
 * @since   Plugin 1.10.0
 *
 * @package project_name
 * @version version
 * @author  Carsten Bach
 *
 * @param   string  $value  The CSS selector to a gallery (or galleries) containing a tags
 *
 * @return  string                      [description]

function selector( string $css_selectors ) : string {
	return join(',', [
		'.wp-block-gallery',
		':not(.wp-block-gallery)>.wp-block-image',
		'.wp-block-media-text__media',
		'.gallery',
		// '.wp-block-coblocks-gallery-masonry',
		// '.wp-block-coblocks-gallery-stacked',
		// '.wp-block-coblocks-gallery-collage',
		// '.wp-block-coblocks-gallery-offset',
		// '.wp-block-coblocks-gallery-stacked',
	] );
} */

/**
 * Filters the image files filter of baguetteBox.js
 *
 * @since   Plugin 1.10.0
 *
 * @package project_name
 * @version version
 * @author  Carsten Bach
 *
 * @param   string  $value  The RegExp Pattern to match image files. Applied to the a.href attribute
 *
 * @return  string                [description]

function filter( string $reg_exp ) : string {
	// this is the plugin default
	// return '/.+\.(gif|jpe?g|png|webp|svg|avif|heif|heic|tif?f|)($|\?)/i';
} */

