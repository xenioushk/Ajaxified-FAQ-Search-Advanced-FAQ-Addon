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
	 * Plugin options.
	 *
	 * @var array $options
	 */
	private $options;

	/**
	 * Modal window ID.
	 *
	 * @var string $modal_id
	 */
	private $modal_id;

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Constructor code here if needed.
		$this->options  = PluginConstants::$addon_options;
		$this->modal_id = 'asf_animated_modal';
	}

	/**
	 * Get the layout for the menu.
	 */
	public function set_sticky_button() {

		$afs_sticky_status = intval( $this->options['afs_sticky_status'] ?? 1 );

		if ( $afs_sticky_status === 0 ) {
			return;
		}

		$output = $this->get_the_sticky_button() . $this->get_modal_window();

		echo $output;  // phpcs:ignore
	}


	/**
	 * Get the sticky button HTML.
	 *
	 * @return string
	 */
	private function get_the_sticky_button() {
		$sticky_btn = '<div class="afs-sticky-container">
														<ul class="afs-sticky">
																<li id="afs_search_popup"  class="afs_search_popup">
																<a href="#' . $this->modal_id . '" id="asf_modal_trigger" title="' . esc_html__( 'Search FAQ', 'afs-addon' ) . '"><i class="fa fa-question-circle"></i>  <span>' . esc_html__( 'Search FAQ', 'afs-addon' ) . '</span></a>
																</li>
														</ul>
												</div>';

		return $sticky_btn;
	}


	/**
	 * Get the modal window HTML.
	 *
	 * @return string
	 */
	private function get_modal_window() {

		// 0=Accordion , 1=Suggestion Box
		$result_type = $this->options['afs_sticky_search_result_type'] ?? 0;
		$placeholder = $this->options['afs_placeholder_text'] ?? esc_html__( 'Search Keywords (how to, what is )..... ', 'afs-addon' );

		$search_box = do_shortcode( "[afs_search sugg_box='" . $result_type . "' placeholder='" . $placeholder . "'/]" );

		$modal_window = '<div id="' . $this->modal_id . '">
																		<div  id="btn-close-modal" class="close-' . $this->modal_id . '"> 
																				X
																		</div>

																		<div class="modal-content">'
																			. $search_box .
																			'</div>
																	</div>';

		return $modal_window;
	}
}