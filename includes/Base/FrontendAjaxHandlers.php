<?php
namespace AFSADDONWP\Base;

use Xenioushk\BwlPluginApi\Api\AjaxHandlers\AjaxHandlersApi;

use AFSADDONWP\Callbacks\FrontendAjaxHandlers\SearchResultsCb;

/**
 * Class for frontend ajax handlers.
 *
 * @package AFSADDONWP
 * @since: 1.1.0
 * @author: Mahbub Alam Khan
 */
class FrontendAjaxHandlers {

	/**
	 * Register frontend ajax handlers.
	 */
	public function register() {

		$ajax_handlers_api = new AjaxHandlersApi();

		// Initalize Callbacks.

		$search_results_cb = new SearchResultsCb();

		// Do not change the tag.
		// If do so, you need to change in js file too.
		$ajax_requests = [
			[
				'tag'      => 'afs_get_search_results',
				'callback' => [ $search_results_cb, 'get_results' ],
			],
		];

		$ajax_handlers_api->add_ajax_handlers( $ajax_requests )->register();
	}
}
