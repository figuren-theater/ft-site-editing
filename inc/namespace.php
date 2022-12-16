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
		'copyright-block'        => true, // needed by ft-network-block-patterns
		'dinosaur-game'          => false,
		'gallery-block-lightbox' => true,
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
	Copyright_Block\bootstrap();
	Dinosaur_Game\bootstrap();
	Gallery_Block_Lightbox\bootstrap();
	Newspaper_Columns\bootstrap();
	Social_Sharing_Block\bootstrap();
	Superlist_Block\bootstrap();
	Todo_Block\bootstrap();
	
	// Best practices
	//...\bootstrap();
}
