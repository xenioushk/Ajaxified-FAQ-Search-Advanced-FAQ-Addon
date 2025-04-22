<?php
namespace AFSADDONWP\Helpers;

/**
 * Class for plugin constants.
 *
 * @package AFSADDONWP
 */
class PluginConstants {

		/**
         * Static property to hold plugin options.
         *
         * @var array
         */
	public static $plugin_options = [];

		/**
         * Static property to hold addon options.
         *
         * @var array
         */
	public static $addon_options = [];

	/**
	 * Initialize the plugin options.
	 */
	public static function init() {

		define( 'AFSADDONWP_OPTIONS_ID', 'afs_options' );

		self::$plugin_options = get_option( 'bwl_advanced_faq_options' );
		self::$addon_options  = get_option( AFSADDONWP_OPTIONS_ID );
	}

	/**
	 * Get the relative path to the plugin root.
	 *
	 * @return string
	 * @example wp-content/plugins/<plugin-name>/
	 */
	public static function get_plugin_path(): string {
		return dirname( dirname( __DIR__ ) ) . '/';
	}

	/**
	 * Get the plugin URL.
	 *
	 * @return string
	 * @example http://appealwp.local/wp-content/plugins/<plugin-name>/
	 */
	public static function get_plugin_url(): string {
		return plugin_dir_url( self::get_plugin_path() . AFSADDONWP_PLUGIN_ROOT_FILE );
	}

	/**
	 * Register the plugin constants.
	 */
	public static function register() {
		self::init();
		self::set_paths_constants();
		self::set_base_constants();
		self::set_assets_constants();
		self::set_updater_constants();
		self::set_product_info_constants();
	}

	/**
	 * Set the plugin base constants.
     *
	 * @example: $plugin_data = get_plugin_data( AFSADDONWP_PLUGIN_DIR . '/' . AFSADDONWP_PLUGIN_ROOT_FILE );
	 * echo '<pre>';
	 * print_r( $plugin_data );
	 * echo '</pre>';
	 * @example_param: Name,PluginURI,Description,Author,Version,AuthorURI,RequiresAtLeast,TestedUpTo,TextDomain,DomainPath
	 */
	private static function set_base_constants() {
		// This is super important to check if the get_plugin_data function is already loaded or not.
		if ( ! function_exists( 'get_plugin_data' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		$plugin_data = get_plugin_data( AFSADDONWP_PLUGIN_DIR . AFSADDONWP_PLUGIN_ROOT_FILE );

		define( 'AFSADDONWP_PLUGIN_VERSION', $plugin_data['Version'] ?? '1.0.0' );
		define( 'AFSADDONWP_PLUGIN_TITLE', $plugin_data['Name'] ?? 'Ajaxified FAQ Search - Advanced FAQ Addon' );
		define( 'AFSADDONWP_TRANSLATION_DIR', $plugin_data['DomainPath'] ?? '/lang/' );
		define( 'AFSADDONWP_TEXT_DOMAIN', $plugin_data['TextDomain'] ?? '' );

		define( 'AFSADDONWP_PLUGIN_FOLDER', 'ajaxified-faq-search' );
		define( 'AFSADDONWP_PLUGIN_CURRENT_VERSION', AFSADDONWP_PLUGIN_VERSION );
	}

	/**
	 * Set the plugin paths constants.
	 */
	private static function set_paths_constants() {
		define( 'AFSADDONWP_PLUGIN_ROOT_FILE', 'ajaxified-faq-search.php' );
		define( 'AFSADDONWP_PLUGIN_DIR', self::get_plugin_path() );
		define( 'AFSADDONWP_PLUGIN_FILE_PATH', AFSADDONWP_PLUGIN_DIR );
		define( 'AFSADDONWP_PLUGIN_URL', self::get_plugin_url() );
		define( 'AFSADDONWP_CONTROLLER_DIR', AFSADDONWP_PLUGIN_DIR . 'includes/Controllers/' );
		define( 'AFSADDONWP_VIEWS_DIR', AFSADDONWP_PLUGIN_DIR . 'includes/Views/' );
	}

	/**
	 * Set the plugin assets constants.
	 */
	private static function set_assets_constants() {
		define( 'AFSADDONWP_PLUGIN_STYLES_ASSETS_DIR', AFSADDONWP_PLUGIN_URL . 'assets/styles/' );
		define( 'AFSADDONWP_PLUGIN_SCRIPTS_ASSETS_DIR', AFSADDONWP_PLUGIN_URL . 'assets/scripts/' );
		define( 'AFSADDONWP_PLUGIN_LIBS_DIR', AFSADDONWP_PLUGIN_URL . 'libs/' );
	}

	/**
	 * Set the updater constants.
	 */
	private static function set_updater_constants() {

		// Only change the slug.
		$slug        = 'baf/notifier_afs.php';
		$updater_url = "https://projects.bluewindlab.net/wpplugin/zipped/plugins/{$slug}";

		define( 'AFSADDONWP_PLUGIN_UPDATER_URL', $updater_url ); // phpcs:ignore
		define( 'AFSADDONWP_PLUGIN_UPDATER_SLUG', AFSADDONWP_PLUGIN_FOLDER . '/' . AFSADDONWP_PLUGIN_ROOT_FILE ); // phpcs:ignore
		define( 'AFSADDONWP_PLUGIN_PATH', AFSADDONWP_PLUGIN_DIR );
	}

	/**
	 * Set the product info constants.
	 */
	private static function set_product_info_constants() {
		define( 'AFSADDONWP_PRODUCT_ID', '12033214' ); // Plugin codecanyon/themeforest Id.
		define( 'AFSADDONWP_PRODUCT_INSTALLATION_TAG', 'baf_afs_installation_' . str_replace( '.', '_', AFSADDONWP_PLUGIN_VERSION ) );
	}
}
