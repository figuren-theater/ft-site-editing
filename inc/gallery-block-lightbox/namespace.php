<?php
/**
 * Figuren_Theater Site_Editing Gallery_Block_Lightbox.
 *
 * @package figuren-theater/site_editing\gallery_block_lightbox
 */

namespace Figuren_Theater\Site_Editing\Gallery_Block_Lightbox;

use FT_VENDOR_DIR;

use Figuren_Theater;
use function Figuren_Theater\get_config;

use function add_action;
use function add_filter;

const BASENAME   = 'gallery-block-lightbox/gallery-block-lightbox.php';
const PLUGINPATH = FT_VENDOR_DIR . '/wpackagist-plugin/' . BASENAME;

/**
 * Bootstrap module, when enabled.
 */
function bootstrap() {

	add_action( 'plugins_loaded', __NAMESPACE__ . '\\load_plugin' );
}

function load_plugin() {

	$config = Figuren_Theater\get_config()['modules']['site_editing'];
	if ( ! $config['gallery-block-lightbox'] )
		return; // early

	require_once PLUGINPATH;

	add_filter('baguettebox_enqueue_assets', __NAMESPACE__ . '\\enqueue_assets' );
	// add_filter( 'baguettebox_selector', __NAMESPACE__ . '\\selector' );
	// add_filter( 'baguettebox_filter', __NAMESPACE__ . '\\filter' );
}


/**
 * Filters whether baguettebox assets have to be enqueued.
 *
 * @since   Plugin 1.11
 *
 * 
 *
 * @package project_name
 * @version version
 * @author  Carsten Bach
 *
 * @param   bool  $value  Whether baguettebox assets have to be enqueued.
 * 
 * @return  bool                            [description]
 */
function enqueue_assets( bool $should_load_scripts ) : bool {
	return (
		\has_block( 'core/gallery' ) ||
		\has_block( 'core/image' ) ||
		\has_block( 'core/media-text' ) ||
		\get_post_gallery() 
		// has_block( 'coblocks/gallery-masonry' ) ||
		// has_block( 'coblocks/gallery-stacked' ) ||
		// has_block( 'coblocks/gallery-collage' ) ||
		// has_block( 'coblocks/gallery-offset' ) ||
		// has_block( 'coblocks/gallery-stacked' )
	);
}

/**
 * Filters the CSS selector of baguetteBox.js
 *
 * @since   Plugin 1.10.0
 *
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

