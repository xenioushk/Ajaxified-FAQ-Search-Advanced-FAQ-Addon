<?php
namespace FTFWCWP\Base;

use Xenioushk\BwlPluginApi\Api\PluginUpdate\WpAutoUpdater;

/**
 * Class for plugin update.
 *
 * @since: 1.1.0
 * @package FTFWCWP
 */
class PluginUpdate {

  	/**
     * Register the plugin text domain.
     */
	public function register() {
		add_action( 'admin_init', [ $this, 'check_for_the_update' ] );
	}

	/**
     * Check for the plugin update.
     */
	public function check_for_the_update() {
		new WpAutoUpdater( FTFWCWP_PLUGIN_VERSION, FTFWCWP_PLUGIN_UPDATER_URL, FTFWCWP_PLUGIN_UPDATER_SLUG );
	}
}
