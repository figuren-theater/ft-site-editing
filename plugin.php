<?php
/**
 * ft-site-editing
 *
 * @package           figuren-theater/site-editing
 * @author            figuren.theater
 * @copyright         2023 figuren.theater
 * @license           GPL-3.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       figuren.theater | Site Editing
 * Plugin URI:        https://github.com/figuren-theater/ft-site-editing
 * Description:       Packages to improve or extend the editing experience within the WordPress Site Editor (called Gutenberg for a long time) for all sites of the figuren.theater multisite network.
 * Version:           1.2
 * Requires at least: 6.0
 * Requires PHP:      7.2
 * Author:            figuren.theater
 * Author URI:        https://figuren.theater
 * Text Domain:       figurentheater
 * Domain Path:       /languages
 * License:           GPL v3 or later
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Update URI:        https://github.com/figuren-theater/ft-site-editing
 */

namespace Figuren_Theater\Site_Editing;

const DIRECTORY = __DIR__;

add_action( 'altis.modules.init', __NAMESPACE__ . '\\register' );
