<?php
namespace AFSADDONWP\Controllers\Actions;

use Xenioushk\BwlPluginApi\Api\Actions\ActionsApi;
use AFSADDONWP\Callbacks\Actions\AfsStickyButtonCb;

/**
 * Class for registering the ajaxfied faq search actions.
 *
 * @since: 1.1.0
 * @package AFSADDONWP
 */
class AfsAddonActions {

    /**
	 * Register actions.
	 */
    public function register() {

        // Initialize API.
        $actions_api = new ActionsApi();

        // Initialize callbacks.
        $afs_sticky_button_cb = new AfsStickyButtonCb();

        $actions = [
            [
                'tag'      => 'wp_footer',
                'callback' => [ $afs_sticky_button_cb, 'set_sticky_button' ],
            ],

        ];

        $actions_api->add_actions( $actions )->register();
    }
}
