<?php
namespace AFSADDONWP\Callbacks\Actions;

use AFSADDONWP\Helpers\PluginConstants;

/**
 * Class for registering recaptcha overlay actions.
 *
 * @package AFSADDONWP
 * @since: 1.0.0
 * @author: Mahbub Alam Khan
 */
class AfsStickyButtonCb {

	/**
	 * Get the layout for the menu.
	 */
	public function set_sticky_button() {

		$options = PluginConstants::$addon_options;

		$afs_sticky_status = $options['afs_sticky_status'] ?? 1;
		// 0=Accordion , 1=Suggestion Box
		$afs_sticky_search_result_type = $options['afs_sticky_search_result_type'] ?? 0;
		$afs_placeholder_text          = $options['afs_placeholder_text'] ?? esc_html__( 'Search Keywords (how to, what is )..... ', 'afs-addon' );

		$afs_sticky_html = '';

		if ( $afs_sticky_status == 1 ) {

			$afs_search_html         = '';
			$afs_search_modal_window = '';

			$afs_search_html .= '<li id="afs_search_popup"  class="afs_search_popup">
                                           <a href="#asf_animated_modal" id="asf_modal_trigger" title="' . esc_html__( 'Search FAQ', 'afs-addon' ) . '"><i class="fa fa-question-circle"></i>  <span>' . esc_html__( 'Search FAQ', 'afs-addon' ) . '</span></a>
                                          </li>';

			$afs_search_modal_window .= '<div id="asf_animated_modal">
                                                            <div  id="btn-close-modal" class="close-asf_animated_modal"> 
                                                                X
                                                            </div>

                                                            <div class="modal-content">'
            . do_shortcode( "[afs_search sugg_box='" . $afs_sticky_search_result_type . "' placeholder='" . $afs_placeholder_text . "'/]" ) .
            '</div>
                                                        </div>';

			$afs_sticky_html .= '<div class="afs-sticky-container">
                                            <ul class="afs-sticky">
                                            ' . $afs_search_html . '
                                            </ul>
                                      </div>';

			$afs_sticky_html = $afs_sticky_html . $afs_search_modal_window;
		}

		echo $afs_sticky_html;
	}
}