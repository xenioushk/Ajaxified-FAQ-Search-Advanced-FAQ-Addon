<?php
/**
 * Plugin Name: Ajaxified FAQ Search - Advanced FAQ Addon
 * Plugin URI: https://bluewindlab.net/portfolio/ajaxified-faq-search-advanced-faq-addon/
 * Description: Integrate a sticky search to get FAQ quickly and efficiently.
 * Author: BlueWindLab
 * Version: 2.1.2
 * Author URI: https://bluewindlab.net
 * WP Requires at least: 6.0+
 * Text Domain: afs-addon
 * Domain Path: /lang/
 *
 * @package   AFSADDONWP
 * @author    Mahbub Alam Khan
 * @license   GPL-2.0+
 * @link      https://codecanyon.net/user/xenioushk
 * @copyright 2025 BlueWindLab
 */

namespace AFSADDONWP;

// security check.
defined( 'ABSPATH' ) || die( 'Unauthorized access' );

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}
// Load the plugin constants
if ( file_exists( __DIR__ . '/includes/Helpers/DependencyManager.php' ) ) {
	require_once __DIR__ . '/includes/Helpers/DependencyManager.php';
	Helpers\DependencyManager::register();
}

use AFSADDONWP\Base\Activate;
use AFSADDONWP\Base\Deactivate;

/**
 * Function to handle the activation of the plugin.
 *
 * @return void
 */
   function activate_plugin() { // phpcs:ignore
	$activate = new Activate();
	$activate->activate();
}

/**
 * Function to handle the deactivation of the plugin.
 *
 * @return void
 */
   function deactivate_plugin() { // phpcs:ignore
	Deactivate::deactivate();
}

register_activation_hook( __FILE__, __NAMESPACE__ . '\\activate_plugin' );
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\\deactivate_plugin' );

/**
 * Function to handle the initialization of the plugin.
 *
 * @return void
 */
function init_afs_addon_wp() {

	// Check if the parent plugin installed.
	if ( ! class_exists( 'BwlFaqManager\\Init' ) ) {
		add_action( 'admin_notices', [ Helpers\DependencyManager::class, 'notice_missing_main_plugin' ] );
		return;
	}

	if ( class_exists( 'AFSADDONWP\\Init' ) ) {

		// Check the required minimum version of the parent plugin.
		if ( ! ( Helpers\DependencyManager::check_minimum_version_requirement_status() ) ) {
			add_action( 'admin_notices', [ Helpers\DependencyManager::class, 'notice_min_version_main_plugin' ] );
			return;
		}

		// Initialize the plugin.
		Init::register_services();
	}
}

add_action( 'init', __NAMESPACE__ . '\\init_afs_addon_wp' );
