<?php
namespace AFSADDONWP\Callbacks\FrontendAjaxHandlers;

use BwlFaqManager\Helpers\FaqColorScheme;
use BwlFaqManager\Controllers\Votes\FaqVoteContainer;
use WP_Query;

/**
 * Class for FAQ search results callback.
 *
 * @package AFSADDONWP
 */
class SearchResultsCb {

	/**
	 * Save the installation data.
	 */
	public function get_results() {

		if ( isset( $_REQUEST['afs_ajax_search'] ) ) {

			global $wpdb;

			$unique_faq_container_id  = $_REQUEST['search_box_unique_id'];
			$bwl_advanced_faq_options = get_option( 'bwl_advanced_faq_options' );
			$afs_data                 = get_option( 'afs_options' );

			/*---Like Button Status---*/

			$baf_like_btn_status = 1;

			if ( isset( $bwl_advanced_faq_options['bwl_advanced_faq_like_button_status'] ) ) {

				$baf_like_btn_status = $bwl_advanced_faq_options['bwl_advanced_faq_like_button_status'];
			}

			/* ----- Logged In Requirement For Voting Status ---- */

			if ( isset( $bwl_advanced_faq_options['baf_logged_in_voting_status'] ) && $bwl_advanced_faq_options['baf_logged_in_voting_status'] == 1 ) {

				if ( ! is_user_logged_in() ) {

					$baf_like_btn_status = 0;
				}
			}

			$like  = '';
			$where = '';
			$s     = trim( $_REQUEST['s'] );
			$s     = preg_replace( '/\s+/', ' ', $s );

			$limit = 10;

			$not_exactonly          = false;
			$searchintitle          = true;
			$searchincontent        = true;
			$searchinposts          = false;
			$searchinpages          = false;
			$searchInCustomPostType = true;

			$post_type = 'post';

			if ( $searchintitle ) {
				if ( $not_exactonly ) {
					$sr = implode( "%' OR lower($wpdb->posts.post_title) like '%", $_s );
					$sr = " lower($wpdb->posts.post_title) like '%" . $sr . "%'";
				} else {
					$sr = " lower($wpdb->posts.post_title) like '%" . $s . "%'";
				}
				$like .= $sr;
			}

			if ( $searchincontent ) {
				if ( $not_exactonly ) {
					$sr = implode( "%' OR lower($wpdb->posts.post_content) like '%", $_s );
					if ( $like != '' ) {
						$sr = " OR lower($wpdb->posts.post_content) like '%" . $sr . "%'";
					} else {
						$sr = " lower($wpdb->posts.post_content) like '%" . $sr . "%'";
					}
				} elseif ( $like != '' ) {
						$sr = " OR lower($wpdb->posts.post_content) like '%" . $s . "%'";
				} else {
					$sr = " lower($wpdb->posts.post_content) like '%" . $s . "%'";
				}
				$like .= $sr;
			}

			if ( $searchinposts ) {
				$where = " $wpdb->posts.post_type='post'";
			}

			if ( $searchinpages ) {
				$post_type = 'page';
				if ( $where != '' ) {
					$where .= " OR $wpdb->posts.post_type='page'";
				} else {
					$where .= "$wpdb->posts.post_type='page'";
                }
			}

			if ( $searchInCustomPostType ) {
				$post_type = 'bwl_advanced_faq';
				if ( $where != '' ) {
					$where .= " OR $wpdb->posts.post_type='bwl_advanced_faq'";
				} else {
					$where .= "$wpdb->posts.post_type='bwl_advanced_faq'";
                }
			}

			if ( $where == '' ) {
				$where = "$wpdb->posts.post_type=''";
			}

			$orderby = 'ID';

			$s = strtolower( addslashes( $_REQUEST['s'] ) );

			if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {

				$querystr = "SELECT 
            $wpdb->posts.guid as permalink ,
            $wpdb->posts.post_title,
            $wpdb->posts.ID as id,
            $wpdb->posts.post_date as date,
            $wpdb->posts.post_content,
            $wpdb->posts.post_excerpt as excerpt,
            $wpdb->users.user_nicename as author
                    FROM $wpdb->posts
            {$join}
                    WHERE
          ($wpdb->posts.post_status='publish') AND
          (" . $where . ')			    
          AND (' . $like . ")
          GROUP BY
            $wpdb->posts.ID 
                    ORDER BY " . $wpdb->posts . '.' . $orderby . "
                    LIMIT $limit ";

				global $sitepress;

				$join .= " INNER JOIN {$wpdb->prefix}icl_translations
             ON {$wpdb->posts}.ID = {$wpdb->prefix}icl_translations.element_id";

				$where .= $wpdb->prepare(") AND ({$wpdb->prefix}icl_translations.language_code = %s
                              AND {$wpdb->prefix}icl_translations.element_type = %s", $sitepress->get_current_language(), "post_{$post_type}");

				$pageposts = $wpdb->get_results( $querystr, OBJECT );
			} else {

				$args = [
					's'              => trim( $s ),
					'post_type'      => 'bwl_advanced_faq',
					'post_status'    => 'publish',
					'posts_per_page' => $limit,
					'orderby'        => $orderby,
				];

				$query     = new WP_Query( $args );
				$pageposts = $query->posts;
			}

			if ( isset( $_POST['output_format'] ) && $_POST['output_format'] == 'JSON' ) {

				$output  = [];
				$counter = 0;
				foreach ( $pageposts as $k => $v ) {

					$output[ $counter ]['link']  = get_permalink( $v->ID );
					$output[ $counter ]['title'] = $v->post_title;
					// $output[$counter]['content'] = strip_tags($v->content);
					++$counter;
				}

				$results = $output;

				echo wp_json_encode( $results );
				wp_die();
			}

			$final_output = '';

			if ( count( $pageposts ) == 0 ) {

				$final_output .= '<div class="afs-nothing-found"><i class="fa fa-info-o"></i> ' . esc_html__( 'Sorry Nothing Found!', 'afs-addon' ) . '</div>';
			} else {

				$preset    = 0;
				$schema    = 0;
				$pag_limit = $afs_data['afs_faq_per_page'] ?? 5 ?: 5;

				$theme_id = $bwl_advanced_faq_options['bwl_advanced_faq_theme'] ?? 'default' ?: 'default';
				$preset   = $theme_id == 'default' ? 0 : 1;

				$faqColorScheme = new FaqColorScheme();

				$baf_predefined_theme_color_scheme = $faqColorScheme->baf_get_theme_color_scheme( $theme_id, $preset );

				// For Custom Theme Color.
				$first_color      = $baf_predefined_theme_color_scheme['first_color'] ?? '#F7F7F7' ?: '#F7F7F7'; // Deafult Gradient First Color.
				$second_color     = $baf_predefined_theme_color_scheme['second_color'] ?? '#FAFAFA' ?: '#FAFAFA'; // Deafult Gradient Second Color.
				$label_text_color = $baf_predefined_theme_color_scheme['label_text_color'] ?? '#777777' ?: '#777777'; // Deafult Gradient Second Color.

				$baf_accordion_arrow = $bwl_advanced_faq_options['bwl_advanced_fa_arrow_up'] ?? "\f106" ?: "\f106"; // Deafult Gradient Second Color.

				// echo "<pre>";
				// print_r($theme_id);
				// print_r($preset);
				// print_r($baf_predefined_theme_color_scheme);
				// echo "</pre>";
				// die();
				// End of color schema.

				$baf_section_class = ( isset( $custom_layout ) && $custom_layout != '' ) ? 'ac-container' . ' ' . $custom_layout : 'ac-container';

				$section_faq_unique_class = ' section_baf_' . $unique_faq_container_id;

				$tag_row_open = '';

				if ( isset( $row_open ) && $row_open != '' ) {
					$section_faq_unique_class .= ' baf_row_open ';
					$tag_row_open             .= 'data-row_open="' . $row_open . '"';
				}

				$final_output .= '<section class="baf_custom_style ' . $section_faq_unique_class . ' ' . $baf_section_class . '" container_id="' . $unique_faq_container_id . '" data-first_color="' . $first_color . '" data-second_color="' . $second_color . '" data-label_text_color="' . $label_text_color . '" data-accordion_arrow="' . str_replace( '\\', '', $baf_accordion_arrow ) . '" ' . $tag_row_open . '  data-schema="' . $schema . '">'; // Open the container

				$final_output .= '<input type="hidden" id="current_page"><input type="hidden" id="show_per_page">  ';

				if ( isset( $bwl_advanced_faq_options['bwl_collapsible_btn_status'] ) && $bwl_advanced_faq_options['bwl_collapsible_btn_status'] == 1 ) {

					$final_output .= '<div class="baf-ctrl-btn"><span class="baf-expand-all"><i class="fa fa-plus"></i></span><span class="baf-collapsible-all"><i class="fa fa-minus"></i></span></div>';
				}

				foreach ( $pageposts as $k => $v ) {

					$content = $v->post_content;
					$content = apply_filters( 'the_content', $content );
					$content = str_replace( ']]>', ']]&gt;', $content );

					$final_output .= $this->get_the_faq_layout( $unique_faq_container_id, $v->ID, $v->post_title, $content, $baf_like_btn_status );
				}

				$final_output .= '<div id="baf_page_navigation" class="baf_page_navigation" data-paginate="' . 1 . '" data-pag_limit="' . $pag_limit . '"></div>';

				$final_output .= '</section>'; // Close the container

			}

			echo $final_output; //phpcs:ignore
		}

		wp_die();
	}


	/**
	 * Get HTML FAQ interface.
	 *
	 * @param string $unique_faq_container_id Unique FAQ container ID.
	 * @param int    $post_id Post ID.
	 * @param string $title Title.
	 * @param string $content Content.
	 * @param int    $baf_like_btn_status Like button status.
	 *
	 * @return string
	 */
	public function get_the_faq_layout( $unique_faq_container_id, $post_id, $title, $content, $baf_like_btn_status ) {

			$id_prefix = '';
			$output    = ''; // Open the container

			/*------------------------------ Get Options For Search Settings  ---------------------------------*/

			$bwl_advanced_faq_options = get_option( 'bwl_advanced_faq_options' );

			$bwl_advanced_faq_search_status = 1;

		if ( isset( $bwl_advanced_faq_options['bwl_advanced_faq_search_status'] ) ) {

				$bwl_advanced_faq_search_status = $bwl_advanced_faq_options['bwl_advanced_faq_search_status'];
		}

			/*------------------------------ FAQ Post Date/Time Information ---------------------------------*/

			$bwl_advanced_faq_meta_info_status = 0;

		if ( isset( $bwl_advanced_faq_options['bwl_advanced_faq_meta_info_status'] ) ) {

				$bwl_advanced_faq_meta_info_status = $bwl_advanced_faq_options['bwl_advanced_faq_meta_info_status'];
		}

			$bwl_advanced_faq_meta_info                = '';
			$bwl_advanced_faq_show_date_time_interface = '';

			/*------------------------------ FAQ Author Information ---------------------------------*/

			$bwl_advanced_faq_author_info_interface = '';

			/*------------------------------ Like Button Status ---------------------------------*/

			$bwl_advanced_faq_like_button_interface = '';

		if ( $baf_like_btn_status == 1 ) {

				$faqVoteContainer                       = new FaqVoteContainer();
				$bwl_advanced_faq_like_button_interface = $faqVoteContainer->getVoteContainer( $post_id );
		}

			// Get Author FAQ Author Information
			$bwl_advanced_faq_author = get_post_meta( $post_id, 'bwl_advanced_faq_author', true );

			$bwl_advanced_faq_author_name = ( $bwl_advanced_faq_author == '' ) ? esc_html__( 'Anonymous', 'afs-addon' ) : get_the_author_meta( 'display_name', $bwl_advanced_faq_author );

			$bwl_advanced_faq_author_info_interface = "<span class='fa fa-user'></span> " . $bwl_advanced_faq_author_name . ' &nbsp;';

			// Get FAQ Date and Time

			$bwl_advanced_faq_show_date_time_interface = "<span class='fa fa-calendar'></span> " . get_the_date( '', $post_id ) . ' &nbsp;';

		if ( $bwl_advanced_faq_meta_info_status == 1 ) {

				$bwl_advanced_faq_meta_info = "<p class='bwl_meta_info'>" . $bwl_advanced_faq_author_info_interface . $bwl_advanced_faq_show_date_time_interface . '</p>';
		}

			$faqTitleTag = $bwl_advanced_faq_options['bwl_advanced_label_tag'] ?? 'label' ?: 'label'; // empty, null, or false.

			$output .= '<div class="bwl-faq-container bwl-faq-container-' . $unique_faq_container_id . '" id="faq-' . $post_id . '">' .
					'<' . $faqTitleTag . ' class="baf_schema" label_id="ac-' . $id_prefix . $post_id . '" parent_container_id="' . $unique_faq_container_id . '">' . $title . '</' . $faqTitleTag . '>' .
					'<input id="ac-' . $id_prefix . $unique_faq_container_id . $post_id . '" name="accordion-1" type="checkbox">' .
					'<article class="ac-medium" article_id="ac-' . $id_prefix . $post_id . '"><div class="baf_content">' . $content . $bwl_advanced_faq_meta_info . $bwl_advanced_faq_like_button_interface . '</div></article>' .
					'</div>';

			return $output;
	}
}
