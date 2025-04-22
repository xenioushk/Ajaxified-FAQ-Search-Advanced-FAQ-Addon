<?php
namespace FTFWCWP\Callbacks\OptionsPanel\FieldsSettings;

use FTFWCWP\Callbacks\OptionsPanel\RenderFields\DisplayFieldsRenderCb;

/**
 * Class for registering fields.
 *
 * @package FTFWCWP
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
				'faqftw_tab_title' => [
					'title'    => esc_html__( 'Tab Title:', 'baf-faqtfw' ),
					'callback' => [ $render_cb, 'get_tab_title' ],
				],
				'faqftw_tab_position' => [
					'title'    => esc_html__( 'Tab Position:', 'baf-faqtfw' ),
					'callback' => [ $render_cb, 'get_tab_position' ],
				],
				'faqftw_faq_counter' => [
					'title'    => esc_html__( 'Display FAQ Counter?', 'baf-faqtfw' ),
					'callback' => [ $render_cb, 'get_faq_counter' ],
				],
				'faqftw_auto_hide_tab' => [
					'title'    => esc_html__( 'Hide Tab If Total FAQs Are Zero?', 'baf-faqtfw' ),
					'callback' => [ $render_cb, 'get_auto_hide_tab' ],
				],
				'faqftw_show_search_box' => [
					'title'    => esc_html__( 'Show Search Box?', 'baf-faqtfw' ),
					'callback' => [ $render_cb, 'get_show_search_box' ],
				],
				'faqftw_show_meta_box' => [
					'title'    => esc_html__( 'Show Meta Info Box?', 'baf-faqtfw' ),
					'callback' => [ $render_cb, 'get_show_meta_box' ],
				],
				'faqftw_show_voting_box' => [
					'title'    => esc_html__( 'Show Voting Box?', 'baf-faqtfw' ),
					'callback' => [ $render_cb, 'get_show_voting_box' ],
				],
				'faqftw_enable_pagination' => [
					'title'    => esc_html__( 'Enable FAQ Pagination?', 'baf-faqtfw' ),
					'callback' => [ $render_cb, 'get_enable_pagination' ],
				],
				'faqftw_item_per_page' => [
					'title'    => esc_html__( 'Item Per Page', 'baf-faqtfw' ),
					'callback' => [ $render_cb, 'get_item_per_page' ],
				],
			];

			return $settings_fields;

	}
}
