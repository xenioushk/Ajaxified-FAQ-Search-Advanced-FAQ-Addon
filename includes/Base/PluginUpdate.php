<?php
namespace AFSADDONWP\Base;

use Xenioushk\BwlPluginApi\Api\PluginUpdate\WpAutoUpdater;

/**
 * Class for plugin update.
 *
 * @since: 1.1.0
 * @package AFSADDONWP
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
		new WpAutoUpdater( AFSADDONWP_PLUGIN_VERSION, AFSADDONWP_PLUGIN_UPDATER_URL, AFSADDONWP_PLUGIN_UPDATER_SLUG );
	}
}
