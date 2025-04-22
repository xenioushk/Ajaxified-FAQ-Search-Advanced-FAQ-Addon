<?php
namespace AFSADDONWP\Controllers\Shortcodes;

use Xenioushk\BwlPluginApi\Api\Shortcodes\ShortcodesApi;
use AFSADDONWP\Callbacks\Shortcodes\SearchCb;
/**
 * Class for Addon shortcodes.
 *
 * @since: 1.1.0
 * @package AFSADDONWP
 */
class AddonShortcodes {

    /**
	 * Register shortcode.
	 */
    public function register() {
        // Initialize API.
        $shortcodes_api = new ShortcodesApi();

        // Initialize callbacks.
        $search_cb = new SearchCb();

        // All Shortcodes.
        $shortcodes = [
            [
                'tag'      => 'afs_search',
                'callback' => [ $search_cb, 'get_the_output' ],
            ],
        ];

        $shortcodes_api->add_shortcodes( $shortcodes )->register();
    }
}
