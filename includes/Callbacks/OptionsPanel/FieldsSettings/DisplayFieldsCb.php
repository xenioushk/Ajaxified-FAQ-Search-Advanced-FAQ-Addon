<?php
namespace AFSADDONWP\Callbacks\OptionsPanel\FieldsSettings;

use AFSADDONWP\Callbacks\OptionsPanel\RenderFields\DisplayFieldsRenderCb;

/**
 * Class for registering fields.
 *
 * @package AFSADDONWP
 * @since: 1.0.0
 * @author: Mahbub Alam Khan
 */
class DisplayFieldsCb {

	/**
     * Set the fields for the settings page
     */
    public function get_fields() {

			$render_cb = new DisplayFieldsRenderCb();
			// Register fields here if needed.

			$settings_fields = [
				'afs_sticky_status' => [
					'title'    => esc_html__( 'Display Sticky Button?', 'afs-addon' ),
					'callback' => [ $render_cb, 'get_sticky_status' ],
				],
				'afs_sticky_search_result_type' => [
					'title'    => esc_html__( 'Sticky Search Output Type:', 'afs-addon' ),
					'callback' => [ $render_cb, 'get_sticky_search_result_type' ],
				],
				'afs_placeholder_text' => [
					'title'    => esc_html__( 'Search Placeholder Text', 'afs-addon' ),
					'callback' => [ $render_cb, 'get_search_placeholder_text' ],
				],
				'afs_sticky_container_bg' => [
					'title'    => esc_html__( 'Sticky Container Background:', 'afs-addon' ),
					'callback' => [ $render_cb, 'get_sticky_container_bg' ],
				],
				'afs_search_window_color' => [
					'title'    => esc_html__( 'Search Window Background:', 'afs-addon' ),
					'callback' => [ $render_cb, 'get_search_window_color' ],
				],
				'afs_window_in_animation' => [
					'title'    => esc_html__( 'Window In Animation', 'afs-addon' ),
					'callback' => [ $render_cb, 'get_search_window_in' ],
				],
				'afs_window_out_animation' => [
					'title'    => esc_html__( 'Window Out Animation', 'afs-addon' ),
					'callback' => [ $render_cb, 'get_search_window_out' ],
				],
				'afs_faq_per_page' => [
					'title'    => esc_html__( 'FAQ Pagination(Item Per Page)', 'afs-addon' ),
					'callback' => [ $render_cb, 'get_faq_per_page' ],
				],
				'afs_sugg_box_container_bg' => [
					'title'    => esc_html__( 'Suggestion Box Background', 'afs-addon' ),
					'callback' => [ $render_cb, 'get_sugg_box_container_bg' ],
				],
				'afs_sugg_box_text_color' => [
					'title'    => esc_html__( 'Suggestion Text Background', 'afs-addon' ),
					'callback' => [ $render_cb, 'get_sugg_box_text_color' ],
				],
				'afs_sugg_box_text_hover_color' => [
					'title'    => esc_html__( 'Suggestion Text Hover Color', 'afs-addon' ),
					'callback' => [ $render_cb, 'get_sugg_box_text_hover_color' ],
				],
			];

			return $settings_fields;

	}
}
