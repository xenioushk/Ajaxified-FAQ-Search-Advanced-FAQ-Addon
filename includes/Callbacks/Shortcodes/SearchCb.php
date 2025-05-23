<?php
namespace AFSADDONWP\Callbacks\Shortcodes;

/**
 * Class for Woo FAQ Tab shortcode callback.
 *
 * @package AFSADDONWP
 * @since: 1.0.0
 * @author: Mahbub Alam Khan
 */
class SearchCb {

	/**
	 * Get the output.
	 *
	 * @param array $atts Attributes.
	 *
	 * @return string
	 */
	public function get_the_output( $atts ) {
		// Introduced in version 1.0.1
		$atts = shortcode_atts([
            'sugg_box'    => 0,
            'placeholder' => esc_html__( 'Search Keywords (how to, what is )..... ', 'afs-addon' ),
		], $atts);

		extract( $atts ); // phpcs:ignore

		if ( $sugg_box == 1 ) {

			$afs_suggestion_box = 1;
		} else {

			$afs_suggestion_box = 0; // Will pick this value dynamically from option panel. Default is 0.
		}

		$afs_live_search_html = '';

		$search_box_unique_id = wp_rand();

		if ( $afs_suggestion_box == 1 ) {

			$afs_search_result_output = '<div class="suggestionsBox" id="suggestions_' . $search_box_unique_id . '" style="display: none;">
																											<div class="suggestionList" id="suggestionsList_' . $search_box_unique_id . '"> &nbsp; </div>
																									</div> <!-- end suggestionsBox -->';
		} else {

			$afs_search_result_output = '<div class="output_suggestionsBox" id="output_suggestions_' . $search_box_unique_id . '" style="display: none;"></div>';
		}

		$afs_live_search_html .= '<form id="form" action="' . esc_url( get_home_url() ) . '/faq-search" autocomplete="off" class="afs-live-search-form" method="post">
																			<div id="suggest" class="afs_filter_container">
																					<input type="text" size="25" value="" id="s" name="s" class="s" placeholder="' . $placeholder . '" data-search-box-unique-id="' . $search_box_unique_id . '" data-sugg_box="' . $afs_suggestion_box . '"/>
																					 <span class="afs-btn-clear afs-dn" data-unique_id="' . $search_box_unique_id . '"></span>
																					' . $afs_search_result_output . '
																			</div> <!-- end .afs_filter_container -->
																	</form><!--end .afs-live-search-form -->';

		return $afs_live_search_html;
	}
}
