<?php
namespace FTFWCWP\Callbacks\Filters;

use FTFWCWP\Helpers\PluginConstants;

/**
 * Class for registering woocommerce FAQ tab filter.
 *
 * @package FTFWCWP
 * @since: 1.0.0
 * @author: Mahbub Alam Khan
 */
class WooFaqTabFilterCb {

	/**
	 * Add Custom Tab.
	 *
	 * @param array $tabs Tabs.
	 * @return array
	 */
	public function add_custom_tab( $tabs ) {

		global $product;

		// Get Data From Option Panel Settings.
		$faqftw_options = PluginConstants::$addon_options;

		// Initialize Values.

		$baf_woo_tab_hide_status = 1; // Enable Auto hide
		$faqftw_tab_title        = esc_html__( 'FAQ ', 'baf-faqtfw' ); // Set the title of FAQ Tab.

		if ( isset( $faqftw_options['faqftw_tab_title'] ) && $faqftw_options['faqftw_tab_title'] != '' ) {
				$faqftw_tab_title = esc_html( $faqftw_options['faqftw_tab_title'] ); // Introduced in version 1.0.1
		}

		/*---Start Tab Auto Hide Section---*/

		if ( isset( $faqftw_options['faqftw_auto_hide_tab'] ) && $faqftw_options['faqftw_auto_hide_tab'] == 0 ) {
				$baf_woo_tab_hide_status = 0;
		}

		if ( $baf_woo_tab_hide_status == 1 ) {

				// Count no of KB for current product.
				$faqftw_faq_post_ids = (int) count( get_post_meta( $product->get_id(), 'faqftw_faq_post_ids' ) );

			if ( $faqftw_faq_post_ids == 0 ) {
					return $tabs;
			}
		}

		/*---End Tab Auto Hide Section---*/

		// Set custom position for FAQ tab.
		// Tips: Higher values like 100, 200, 300 will set FAQ tab bottom of the tab container.
		// Set lower value like 1 to set FAQ tab at the first position.

		$faqftw_tab_position = 100; // Set faq tab in last position.

		if ( isset( $faqftw_options['faqftw_tab_position'] ) && is_numeric( $faqftw_options['faqftw_tab_position'] ) ) {

				$faqftw_tab_position = trim( $faqftw_options['faqftw_tab_position'] );
		}

		/*---Search Box Section---*/

		$faqftw_show_search_box = 1; // Set faq tab in last position.

		if ( isset( $faqftw_options['faqftw_show_search_box'] ) ) {

				$faqftw_show_search_box = trim( $faqftw_options['faqftw_show_search_box'] );
		}

		/*---Meta Info Section---*/

		$faqftw_show_meta_box = 1;

		if ( isset( $faqftw_options['faqftw_show_meta_box'] ) ) {

				$faqftw_show_meta_box = trim( $faqftw_options['faqftw_show_meta_box'] );
		}

		/*---Voting Box Section---*/

		$faqftw_show_voting_box = 1;

		if ( isset( $faqftw_options['faqftw_show_voting_box'] ) ) {

				$faqftw_show_voting_box = trim( $faqftw_options['faqftw_show_voting_box'] );
		}

		/*---Pagination Section---*/

		$faqftw_enable_pagination = 1;

		if ( isset( $faqftw_options['faqftw_enable_pagination'] ) ) {

				$faqftw_enable_pagination = trim( $faqftw_options['faqftw_enable_pagination'] );
		}

		/*---No of Items Per Page---*/

		$faqftw_item_per_page = 5;

		if ( isset( $faqftw_options['faqftw_item_per_page'] ) && is_numeric( $faqftw_options['faqftw_item_per_page'] ) ) {

				$faqftw_item_per_page = trim( $faqftw_options['faqftw_item_per_page'] );
		}

		// Specefic Product FAQ Tab Hide section.

		$baf_woo_tab_hide_status = get_post_meta( $product->get_id(), 'baf_woo_tab_hide_status', true );

		if ( isset( $baf_woo_tab_hide_status ) && $baf_woo_tab_hide_status == 1 ) {

				return $tabs;
		}

		$faqtfw_total_faq_string = '';

		$get_faqftw_faq_post_ids = apply_filters( 'filter_baftfwc_content_data', get_post_meta( $product->get_id(), 'faqftw_faq_post_ids' ) );

		$faqftw_faq_post_ids = implode( ',', $get_faqftw_faq_post_ids );

		$tabs['faqtfw_tab'] = [
			'title'    => esc_html( $faqftw_tab_title . $faqtfw_total_faq_string ),
			'priority' => $faqftw_tab_position, // Always display at the end of tab :)
			'callback' => [ $this, 'ftfwc_get_the_content' ],
			'content'  => '[baf_woo_tab post_ids="' . $faqftw_faq_post_ids . '" sbox="' . $faqftw_show_search_box . '"  paginate="' . $faqftw_enable_pagination . '"  pag_limit="' . $faqftw_item_per_page . '" meta_info="' . $faqftw_show_meta_box . '" voting="' . $faqftw_show_voting_box . '"/]', // custom field
		];

		return $tabs;
	}


	/**
	 * Get the content of the tab.
	 *
	 * @param string $key The key of the tab.
	 * @param array  $tab The tab data.
	 */
	public function ftfwc_get_the_content( $key, $tab ) {
		// allow shortcodes to function
		$content = apply_filters( 'the_content', $tab['content'] );
		$content = str_replace( ']]>', ']]&gt;', $content );
		echo apply_filters( 'woocommerce_custom_product_tabs_lite_content', $content, $tab ); // phpcs:ignore
	}
}
