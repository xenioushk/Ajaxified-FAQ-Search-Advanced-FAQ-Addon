<?php
namespace AFSADDONWP\Callbacks\OptionsPanel;

use Xenioushk\BwlPluginApi\Api\View\ViewApi;

/**
 * Class for loading the settings page template.
 *
 * @package AFSADDONWP
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
			'page_title' => 'Ajaxified FAQ Search Settings',
			'options_id' => AFSADDONWP_OPTIONS_ID,
			'page_id'    => 'afs-settings',
		];

		$this->render( AFSADDONWP_VIEWS_DIR . 'Admin/OptionsPanel/tpl_settings_page.php',$data );

	}
}
