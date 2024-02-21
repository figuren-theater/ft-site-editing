<?php
/**
 * Figuren_Theater Site_Editing.
 *
 * @package figuren-theater/ft-site-editing
 */

namespace Figuren_Theater\Site_Editing;

use Altis;

const ASSETS_URL = '/FT/ft-site-editing/assets/';

/**
 * Register module.
 *
 * @return void
 */
function register(): void {

	$default_settings = [
		'enabled'                  => true, // Needs to be set.
		'block-catalog'            => false,
		'block-visibility'         => false,
		'copyright-block'          => true, // Needed by ft-network-block-patterns !
		'dinosaur-game'            => false,
		'embed-block-for-github'   => false,
		'image-source-control-isc' => false,
		'markdown-comment-block'   => false,
		'newspaper-columns'        => true, // Needed by ft-network-block-patterns !
		'superlist-block'          => true, // Needed by ft-network-block-patterns + Impressum !
		'social-sharing-block'     => true, // Needed by ft-network-block-patterns !
		'todo-block'               => true, // Needed by ft-network-block-patterns !
	];
	$options          = [
		'defaults' => $default_settings,
	];

	Altis\register_module(
		'site_editing',
		DIRECTORY,
		'Site_Editing',
		$options,
		__NAMESPACE__ . '\\bootstrap'
	);
}

/**
 * Bootstrap module, when enabled.
 *
 * @return void
 */
function bootstrap(): void {

	// Plugins.
	Abbreviation_Button_For_The_Block_Editor\bootstrap();
	// keep the plugin disabled, for now - as its more helpful for migrations, than day2day ;) !
	// Block_Catalog\bootstrap(); // !
	Block_Visibility\bootstrap();
	Cbstdsys_Post_Subtitle\bootstrap();
	Copyright_Block\bootstrap();
	Dinosaur_Game\bootstrap();
	Embed_Block_For_Github\bootstrap();
	FT_Network_Block_Editor\bootstrap();
	FT_Network_Block_Patterns\bootstrap();
	Icon_Block\bootstrap();
	Image_Source_Control_ISC\bootstrap();
	Markdown_Comment_Block\bootstrap();
	Newspaper_Columns\bootstrap();
	Social_Sharing_Block\bootstrap();
	Superlist_Block\bootstrap();
	Todo_Block\bootstrap();
}
