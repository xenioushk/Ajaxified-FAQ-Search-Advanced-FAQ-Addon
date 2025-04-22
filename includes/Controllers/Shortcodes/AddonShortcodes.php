<?php
namespace FTFWCWP\Controllers\Shortcodes;

use Xenioushk\BwlPluginApi\Api\Shortcodes\ShortcodesApi;
use FTFWCWP\Callbacks\Shortcodes\WooFaqTabCb;
/**
 * Class for Addon shortcodes.
 *
 * @since: 1.1.0
 * @package FTFWCWP
 */
class AddonShortcodes {

    /**
	 * Register shortcode.
	 */
    public function register() {
        // Initialize API.
        $shortcodes_api = new ShortcodesApi();

        // Initialize callbacks.
        $woo_faq_tab_cb = new WooFaqTabCb();

        // All Shortcodes.
        $shortcodes = [
            [
                'tag'      => 'baf_woo_tab',
                'callback' => [ $woo_faq_tab_cb, 'get_the_output' ],
            ],
        ];

        $shortcodes_api->add_shortcodes( $shortcodes )->register();
    }
}
