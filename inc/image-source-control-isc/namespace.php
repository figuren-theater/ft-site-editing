<?php
/**
 * Figuren_Theater Site_Editing Image_Source_Control_ISC.
 *
 * @package figuren-theater/ft-site-editing
 */

namespace Figuren_Theater\Site_Editing\Image_Source_Control_ISC;

use Figuren_Theater;

use Figuren_Theater\Options;
use Figuren_Theater\Site_Editing;
use FT_VENDOR_DIR;
use ISCVERSION;
use ISC_Admin;
use WPMU_PLUGIN_URL;
use WP_Post;
use function add_action;
use function add_filter;
use function did_action;
use function do_blocks;
use function get_option;
use function is_admin;
use function is_network_admin;
use function is_user_admin;
use function remove_action;
use function remove_submenu_page;
use function wp_installing;

const BASENAME   = 'image-source-control-isc/isc.php';
const PLUGINPATH = '/wpackagist-plugin/' . BASENAME;
const OPTION     = 'isc_options';

/**
 * Bootstrap module, when enabled.
 *
 * @return void
 */
function bootstrap(): void {

	add_action( 'Figuren_Theater\loaded', __NAMESPACE__ . '\\filter_options', 11 );

	add_action( 'plugins_loaded', __NAMESPACE__ . '\\load_plugin' );
}

/**
 * Conditionally load the plugin itself and its modifications.
 *
 * @return void
 */
function load_plugin(): void {

	$config = Figuren_Theater\get_config()['modules']['site_editing'];
	if ( ! $config['image-source-control-isc'] ) {
		return;
	}

	if ( is_network_admin() ||
		is_user_admin() ||
		wp_installing() ||
		did_action( 'wp_initialize_site' )
	) {
		return;
	}

	require_once FT_VENDOR_DIR . PLUGINPATH; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant

	add_filter( 'pre_option_' . OPTION, __NAMESPACE__ . '\\re_set_dynamic_options', 20 );

	// Fake a table-block, to load its styles!
	add_filter( 'do_shortcode_tag', __NAMESPACE__ . '\\load_block_table_styles', 10, 2 );

	if ( ! is_admin() ) {
		return;
	}

	add_filter( 'attachment_fields_to_edit', __NAMESPACE__ . '\\remove_attachment_fields', 20 );

	add_action( 'admin_notices', __NAMESPACE__ . '\\remove_notices', 0 );
	add_action( 'admin_menu', __NAMESPACE__ . '\\remove_menu', 11 );

	// Remove "Additional Images" from "Sources" Page,
	// because it was reduced to just a big ad.
	add_action( 'admin_footer-media_page_isc-sources', __NAMESPACE__ . '\\remove_part_of_sources' );
}

/**
 * Handle options
 *
 * @return void
 */
function filter_options(): void {

	$_options = [
		'display_type'              => [],
		'list_on_archives'          => false,
		'list_on_excerpts'          => false,
		'image_list_headline'       => false,
		'version'                   => '', // Will be re-set after ENABLE // prevents auto-updates of this options-field.
		'thumbnail_in_list'         => false,
		'thumbnail_size'            => 'thumbnail',
		'thumbnail_width'           => 150, // Will be re-set after ENABLE.
		'thumbnail_height'          => 150, // Will be re-set after ENABLE.

		// 'warning_onesource_missing' will be changed by Feature 'advanced-isc'.
		'warning_onesource_missing' => false,

		'remove_on_uninstall'       => false,
		'hide_list'                 => false,
		'caption_position'          => 'bottom-right',
		'caption_style'             => true, // Remove markup and CSS.
		'source_pretext'            => '', // Will be re-set after ENABLE.
		'enable_licences'           => true,

		// 'licences' will be changed by Feature 'advanced-isc'
		'licences'                  => 'All Rights Reserved
		Public Domain Mark 1.0|https://creativecommons.org/publicdomain/mark/1.0/
		CC0 1.0 Universal|https://creativecommons.org/publicdomain/zero/1.0/
		CC BY 4.0 International|https://creativecommons.org/licenses/by/4.0/
		CC BY-SA 4.0 International|https://creativecommons.org/licenses/by-sa/4.0/
		CC BY-ND 4.0 International|https://creativecommons.org/licenses/by-nd/4.0/
		CC BY-NC 4.0 International|https://creativecommons.org/licenses/by-nc/4.0/
		CC BY-NC-SA 4.0 International|https://creativecommons.org/licenses/by-nc-sa/4.0/
		CC BY-NC-ND 4.0 International|https://creativecommons.org/licenses/by-nc-nd/4.0/',

		'list_included_images'      => '',
		'overlay_included_images'   => '',
		'enable_log'                => false,
		'standard_source'           => 'custom_text',
		'standard_source_text'      => '', // Will be re-set after ENABLE.

	];

	/*
	 * Gets added to the 'OptionsCollection'
	 * from within itself on creation.
	 */
	new Options\Option(
		'isc_options',
		$_options,
		BASENAME
	);
}

/**
 * Re-set (the more) dynamic options.
 *
 * @param  array<string, mixed>|bool $option ISC-Option if already saved, can be false on WP_INSTALLING.
 *
 * @return array<string, mixed>
 */
function re_set_dynamic_options( array|bool $option ): array {

	$option = ( is_array( $option ) ) ? $option : [];

	$_blogname = get_option( 'blogname' );

	// prevents auto-updates of this options-field.
	$option['version']              = ISCVERSION;
	$option['standard_source_text'] = '© ' . $_blogname;
	// Why is the standard for option 'image_list_headline' disabled ? I dont know ...
	// $option['image_list_headline']  = __('Image Sources','image-source-control-isc'); // ???
	$option['source_pretext']   = __( 'Source:', 'image-source-control-isc' );
	$option['thumbnail_width']  = get_option( 'thumbnail_size_w', 150 );
	$option['thumbnail_height'] = get_option( 'thumbnail_size_h', 150 );

	return $option;
}

/**
 * Filters the attachment fields to edit.
 *
 * @param string[] $fields     An array of attachment form fields.
 *
 * @return string[]
 */
function remove_attachment_fields( array $fields ): array {
	unset( $fields['isc_image_source_pro'] );
	return $fields;
}

/**
 * Fake a 'table'-block to load its styles.
 *
 * Normally this filters the output created by a shortcode callback.
 *
 * @uses    https://developer.wordpress.org/reference/hooks/do_shortcode_tag/
 *
 * @package figuren-theater/site_editing/image_source_control_isc
 *
 * @param   string $output Shortcode output.
 * @param   string $tag    Shortcode name.
 *
 * @return  string                  Totally unchanged Shortcode output.
 */
function load_block_table_styles( string $output, string $tag ): string {
	// Make sure it is the right shortcode.
	if ( 'isc_list_all' !== $tag ) {
		return $output;
	}

	// This triggers the loading of 'table-block's
	// related scripts and styles.
	do_blocks( '<!-- wp:table {"className":"is-style-stripes"} --><!-- /wp:table -->' );

	enqueue_css_fix();

	return $output;
}

/**
 * CLEAN UP branded stuff by removing another annoying admin-notice !
 *
 * @return void
 */
function remove_notices(): void {
	remove_action( 'admin_notices', [ ISC_Admin::get_instance(), 'branded_admin_header' ] );
}

/**
 * Remove the plugins admin-menu.
 *
 * @return void
 */
function remove_menu(): void {
	remove_submenu_page( 'options-general.php', 'isc-settings' );
}

/**
 * Remove "Additional Images" from "Sources" Page,
 * because it was reduced to just a big ad.
 *
 * @return void
 */
function remove_part_of_sources(): void {

	?>
	<script type="text/javascript">
		//<![CDATA[
		jQuery( document ).ready( function( $ ) {
			$( 'body.media_page_isc-sources' ).find( '.isc-table-storage' ).prev().remove();
			$( 'body.media_page_isc-sources' ).find( '.isc-table-storage' ).prev().remove();
			$( 'body.media_page_isc-sources' ).find( '.isc-table-storage' ).remove();
		} );
		//]]>
	</script>
	<?php
}

/**
 * Enqueue minimal CSS fix
 *
 * @return void
 */
function enqueue_css_fix(): void {
	// Same args used for wp_enqueue_style().
	$args = [
		'handle' => 'image-source-control-isc-fix',
		'src'    => WPMU_PLUGIN_URL . Site_Editing\ASSETS_URL . 'image-source-control-isc/fix.css',
	];

	// Add "path" to allow inlining asset if the theme opts-in.
	$args['path'] = Site_Editing\DIRECTORY . 'assets/image-source-control-isc/fix.css';

	// Enqueue asset.
	wp_enqueue_block_style( 'core/table', $args );
}
