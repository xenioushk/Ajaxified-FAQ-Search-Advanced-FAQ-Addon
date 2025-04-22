<?php
namespace FTFWCWP\Controllers\Filters;

use Xenioushk\BwlPluginApi\Api\Filters\FiltersApi;
use FTFWCWP\Callbacks\Filters\TabContentFilterCb;
use FTFWCWP\Callbacks\Filters\WooFaqTabFilterCb;

/**
 * Class for registering the addon filters.
 *
 * @since: 1.1.0
 * @package FTFWCWP
 */
class AddonFilters {

    /**
	 * Register filters.
	 */
    public function register() {

        // Initialize API.
        $filters_api = new FiltersApi();

        // Initialize callbacks.
        $tab_content_filter_cb = new TabContentFilterCb();
        $woo_faq_tab_filter_cb = new WooFaqTabFilterCb();

        $filters = [
            [
                'tag'      => 'filter_baftfwc_content_data',
                'callback' => [ $tab_content_filter_cb, 'modify_content' ],
            ],
            [
                'tag'      => 'woocommerce_product_tabs',
                'callback' => [ $woo_faq_tab_filter_cb, 'add_custom_tab' ],
            ],

        ];

        $filters_api->add_filters( $filters )->register();
    }
}
