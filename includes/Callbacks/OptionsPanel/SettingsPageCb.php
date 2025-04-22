<?php
namespace FTFWCWP\Callbacks\OptionsPanel;

use Xenioushk\BwlPluginApi\Api\View\ViewApi;

/**
 * Class for loading the settings page template.
 *
 * @package FTFWCWP
 * @since: 1.0.0
 * @author: Mahbub Alam Khan
 */
class SettingsPageCb extends ViewApi {

	/**
	 * Load the settings page template.
	 *
	 * @return void
	 */
	public function load_template() {

		$data = [
			'page_title' => esc_html__( 'FAQ Tab For WooCommerce Settings', 'baf-faqtfw' ),
			'options_id' => FTFWCWP_OPTIONS_ID,
			'page_id'    => 'faqftw-settings',
		];

		$this->render( FTFWCWP_VIEWS_DIR . 'OptionsPanel/settings_page_tpl.php',$data );

	}
}
