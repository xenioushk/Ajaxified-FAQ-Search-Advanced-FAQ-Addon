<?php
namespace FTFWCWP\Controllers\Cpt;

/**
 * Custom Columns
 *
 * @package FTFWCWP
 */
class CustomColumns {

	/**
     * Register the column filters.
     */
	public function register() {
		add_action( 'admin_init', [ $this, 'initialize' ] );
	}

    /**
     * Initialize column actions.
     */
	public function initialize() {
		add_filter( 'manage_product_posts_columns', [ $this, 'columns_header' ] );
		add_action( 'manage_product_posts_custom_column', [ $this, 'columns_content' ] );
	}

    /**
     * Add custom columns to the post type.
     *
     * @param array $columns The columns.
     *
     * @return array
     */
	public function columns_header( $columns ) {

		$columns['faqftw_faq_post_ids'] = esc_html__( 'FAQs', 'baf-faqtfw' );

		$columns['baf_woo_tab_hide_status'] = esc_html__( 'FAQs Visibility', 'baf-faqtfw' );

		return $columns;
	}

	/**
     * Add content to the custom columns.
     *
     * @param string $column The column.
     */
	public function columns_content( $column ) {

		// Add A Custom Image Size For Admin Panel.

		global $post;

		switch ( $column ) {

			case 'faqftw_faq_post_ids':
				$get_faqftw_faq_post_ids = apply_filters( 'filter_baftfwc_content_data', get_post_meta( $post->ID, 'faqftw_faq_post_ids' ) );
				$faqftw_faq_post_ids     = (int) count( $get_faqftw_faq_post_ids );
				echo '<div id="faqftw_faq_post_ids-' . $post->ID . '" >&nbsp;' . $faqftw_faq_post_ids . '</div>';

				break;

			case 'baf_woo_tab_hide_status':
				$baf_woo_tab_hide_status = ( get_post_meta( $post->ID, 'baf_woo_tab_hide_status', true ) == '' ) ? '' : get_post_meta( $post->ID, 'baf_woo_tab_hide_status', true );

				// FAQ Display Status In Text.

				$visibilityIcon = FTFWCWP_PLUGIN_LIBS_DIR . 'images/';

				$iconType = ( $baf_woo_tab_hide_status == 1 ) ? 'hidden.png' : 'visible.png';

				echo '<div id="baf_woo_tab_hide_status-' . $post->ID . '" data-status_code="' . $baf_woo_tab_hide_status . '" ><img src="' . $visibilityIcon . $iconType . '"></div>';

				break;
		}
	}
}
