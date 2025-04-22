<?php
namespace FTFWCWP\Callbacks\Shortcodes;

/**
 * Class for Woo FAQ Tab shortcode callback.
 *
 * @package FTFWCWP
 * @since: 1.0.0
 * @author: Mahbub Alam Khan
 */
class WooFaqTabCb {

	/**
	 * Get the output.
	 *
	 * @param array $atts Attributes.
	 *
	 * @return string
	 */
	public function get_the_output( $atts ) {

		$atts = shortcode_atts([
			'post_type'        => 'bwl_advanced_faq',
			'post_ids'         => '',
			'orderby'          => 'post__in',
			'order'            => 'ASC',
			'limit'            => -1,
			'suppress_filters' => 0,
			'sbox'             => 1,
			'paginate'         => 1,
			'pag_limit'        => 5,
			'meta_info'        => 1,
			'voting'           => 1,
		], $atts);

		extract( $atts ); //phpcs:ignore

		return do_shortcode(
			sprintf(
                '[bwla_faq post_ids="%s" orderby="%s" order="%s" sbox="%s" paginate="%s" pag_limit="%s" meta_info="%s" voting="%s" /]',
                $post_ids,
                $orderby,
                $order,
                $sbox,
                $paginate,
                $pag_limit,
                $meta_info,
                $voting
			)
		);
	}
}
