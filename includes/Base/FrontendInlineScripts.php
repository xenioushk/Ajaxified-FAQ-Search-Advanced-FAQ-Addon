<?php
namespace AFSADDONWP\Base;

use AFSADDONWP\Helpers\PluginConstants;

/**
 * Class for plucin frontend inline js.
 *
 * @package AFSADDONWP
 * @since: 1.1.0
 * @auther: Mahbub Alam Khan
 */
class FrontendInlineScripts {

	/**
	 * Register the methods.
	 */
	public function register() {
		add_action( 'wp_head', [ $this, 'set_inline_styles' ] );
	}

	/**
	 * Set the inline styles.
	 */
	public function set_inline_styles() {

        $afs_options = PluginConstants::$addon_options;

        $afs_sticky_container_bg       = $afs_options['afs_sticky_container_bg'] ?? '#2C2C2C';
        $afs_sugg_box_container_bg     = $afs_options['afs_sugg_box_container_bg'] ?? '#2C2C2C';
        $afs_sugg_box_text_color       = $afs_options['afs_sugg_box_text_color'] ?? '#FFFFFF';
        $afs_sugg_box_text_hover_color = $afs_options['afs_sugg_box_text_hover_color'] ?? '#F3F3F3';

        $afs_custom_theme = '<style type="text/css" id="afsaddon-custom-style">';

        /*-- RTL Support For Search Section --*/

        if ( is_rtl() ) {
            // Write all custom codes for RTL in here.
            $afs_custom_theme .= 'span.afs-btn-clear{ left: 5px;}';
        } else {

            $afs_custom_theme .= 'span.afs-btn-clear{ right: 5px;}';
        }

        $afs_custom_theme .= 'ul.afs-sticky li{ background: ' . $afs_sticky_container_bg . ';}';

        /*--  Suggestion Box Background Color --*/

        $afs_custom_theme .= 'div.suggestionsBox{ background: ' . $afs_sugg_box_container_bg . ' !important;}';
        $afs_custom_theme .= 'div.suggestionList:before{ border-bottom: 7px solid ' . $afs_sugg_box_container_bg . ' !important;}';

        /*--  Suggestion Box Text Color --*/

        $afs_custom_theme .= 'div.suggestionList ul li a{ color: ' . $afs_sugg_box_text_color . ' !important;}';
        $afs_custom_theme .= 'div.suggestionList ul li a:hover{ color: ' . $afs_sugg_box_text_hover_color . ' !important;}';

        $afs_custom_theme .= '</style>';

        echo $afs_custom_theme; // phpcs:ignore
	}
}