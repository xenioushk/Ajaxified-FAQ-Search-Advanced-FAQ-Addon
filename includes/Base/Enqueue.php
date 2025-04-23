<?php
namespace AFSADDONWP\Base;

use AFSADDONWP\Helpers\PluginConstants;

/**
 * Class for registering the plugin scripts and styles.
 *
 * @package AFSADDONWP
 */
class Enqueue {

	/**
	 * Frontend script slug.
	 *
	 * @var string $frontend_script_slug
	 */
	private $frontend_script_slug;

	/**
	 * Plugin options.
	 *
	 * @var array $options
	 */

	private $options;

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Frontend script slug.
		// This is required to hook the loclization texts.
		$this->frontend_script_slug = 'baf-afs-frontend';
		$this->options              = PluginConstants::$addon_options;
	}

	/**
	 * Register the plugin scripts and styles loading actions.
	 */
	public function register() {

		// Enqueue scripts and styles.
		add_action( 'wp_enqueue_scripts', [ $this, 'get_the_styles' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'get_the_scripts' ] );
	}

	/**
	 * Load the plugin styles.
	 */
	public function get_the_styles() {

		wp_enqueue_style(
			'afs-simple-popup',
			AFSADDONWP_PLUGIN_LIBS_DIR . 'jquery.simple.popup/styles/popup.css',
			[],
			AFSADDONWP_PLUGIN_VERSION
		);

		wp_enqueue_style(
			'afs-animate',
			AFSADDONWP_PLUGIN_LIBS_DIR . 'animate/styles/animate.min.css',
			[],
			AFSADDONWP_PLUGIN_VERSION
		);

		wp_enqueue_style(
            $this->frontend_script_slug,
            AFSADDONWP_PLUGIN_STYLES_ASSETS_DIR . 'frontend.css',
            [],
            AFSADDONWP_PLUGIN_VERSION
		);

		if ( is_rtl() ) {
			wp_enqueue_style(
				$this->frontend_script_slug . '-rtl',
				AFSADDONWP_PLUGIN_STYLES_ASSETS_DIR . 'frontend_rtl.css',
				[],
				AFSADDONWP_PLUGIN_VERSION
			);
		}
	}

	/**
	 * Load the plugin scripts.
	 */
	public function get_the_scripts() {

		// Register JS

		wp_enqueue_script(
			'afs-animate-modal',
			AFSADDONWP_PLUGIN_LIBS_DIR . 'animated.modal/scripts/animatedModal.min.js',
			[ 'jquery' ],
			AFSADDONWP_PLUGIN_VERSION,
			true
		);

		wp_enqueue_script(
            $this->frontend_script_slug,
            AFSADDONWP_PLUGIN_SCRIPTS_ASSETS_DIR . 'frontend.js',
            [ 'jquery', 'afs-animate-modal' ],
            AFSADDONWP_PLUGIN_VERSION,
            true
		);

		// Load frontend variables used by the JS files.
		$this->get_the_localization_texts();
	}

	/**
	 * Load the localization texts.
	 */
	private function get_the_localization_texts() {

		// Localize scripts.
		// Frontend.
		// Access data: BafAfsData.version

		$window_in_animation  = $this->options['afs_window_in_animation'] ?? 'zoomIn';
		$window_out_animation = $this->options['afs_window_out_animation'] ?? 'zoomOut';
		$search_window_color  = $this->options['afs_search_window_color'] ?? '#3498DB';

		wp_localize_script(
            $this->frontend_script_slug,
            'BafAfsData',
            [
				'version'                   => AFSADDONWP_PLUGIN_VERSION,
				'afs_window_in_animation'   => $window_in_animation,
				'afs_window_out_animation'  => $window_out_animation,
				'afs_search_window_color'   => $search_window_color,
				'afs_search_no_results_msg' => esc_html__( 'Sorry Nothing Found!', 'afs-addon' ),
			]
		);
	}
}