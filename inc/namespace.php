<?php
/**
 * Figuren_Theater Site_Editing.
 *
 * @package figuren-theater/site_editing
 */

namespace Figuren_Theater\Site_Editing;

use Altis;
use function Altis\register_module;


const ASSETS_URL = WPMU_PLUGIN_URL . '/FT/ft-site-editing/assets/';


/**
 * Register module.
 */
function register() {

	$default_settings = [
		'enabled'                => true, // needs to be set
		'block-visibility'       => false,
		'copyright-block'        => true, // needed by ft-network-block-patterns
		'dinosaur-game'          => false,
		'embed-block-for-github' => false,
		'gallery-block-lightbox' => true,
		'markdown-comment-block' => false,
		'newspaper-columns'      => true,
		'superlist-block'        => true,
		'social-sharing-block'   => true,
		'todo-block'             => true,
	];
	$options = [
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
 */
function bootstrap() {

	// Plugins
	Abbreviation_Button_For_The_Block_Editor\bootstrap();
	Block_Visibility\bootstrap();
	Cbstdsys_Post_Subtitle\bootstrap();
	Copyright_Block\bootstrap();
	Dinosaur_Game\bootstrap();
	Embed_Block_For_Github\bootstrap();
	Gallery_Block_Lightbox\bootstrap();
	Icon_Block\bootstrap();
	Image_Source_Control_ISC\bootstrap();
	Lang_Attribute\bootstrap();
	Markdown_Comment_Block\bootstrap();
	Newspaper_Columns\bootstrap();
	Social_Sharing_Block\bootstrap();
#	Superlist_Block\bootstrap();
	Todo_Block\bootstrap();

	// f.t
	FT_Network_Block_Editor\bootstrap();
	FT_Network_Block_Patterns\bootstrap();
	
	// Best practices
	//...\bootstrap();
}
