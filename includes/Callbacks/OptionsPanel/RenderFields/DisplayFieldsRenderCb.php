<?php
namespace AFSADDONWP\Callbacks\OptionsPanel\RenderFields;

use AFSADDONWP\Helpers\PluginConstants;
use BwlFaqManager\Traits\OptionsFieldsTraits;

/**
 * Class for rendering the fields.
 *
 * @package AFSADDONWP
 * @since: 1.0.0
 * @author: Mahbub Alam Khan
 */
class DisplayFieldsRenderCb {

	use OptionsFieldsTraits;

	/**
	 * Options array.
     *
	 * @var array
	 */
	public $options;

	/**
	 * Options ID.
	 *
	 * @var string
	 */
	public $options_id;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->options    = PluginConstants::$addon_options;
		$this->options_id = AFSADDONWP_OPTIONS_ID; // change here.
	}


	/**
	 * Get sticky status field.
	 */
	public function get_sticky_status() {

		$field_id   = 'afs_sticky_status'; // change the id.
		$field_name = $this->options_id . "[{$field_id}]";
		$value      = $this->options[ $field_id ] ?? 1; // change default value.

		echo $this->get_select_field( $field_name, $field_id, $this->get_boolean_dropdown_options(), $value  ); //phpcs:ignore
	}

	/**
	 * Get search result type field.
	 */
	public function get_sticky_search_result_type() {

		$field_id   = 'afs_sticky_search_result_type'; // change the id.
		$field_name = $this->options_id . "[{$field_id}]";
		$options    = [
			0 => esc_html__( 'Accordion (Default)', 'afs-addon' ),
			1 => esc_html__( 'Suggestion Box', 'afs-addon' ),
		];
		$value      = $this->options[ $field_id ] ?? 1; // change default value.

		echo $this->get_select_field( $field_name, $field_id, $options, $value  ); //phpcs:ignore
	}

	/**
	 * Get search placeholder text field.
	 */
	public function get_search_placeholder_text() {

		$field_id   = 'afs_placeholder_text'; // change the id.
		$field_name = $this->options_id . "[{$field_id}]";
		$value      = $this->options[ $field_id ] ?? esc_html__( 'Search Keywords (how to, what is )..... ', 'afs-addon' );

		echo $this->get_text_field( $field_name, $field_id, $value,'', 'regular-text' ); //phpcs:ignore

	}

	/**
	 * Get sticky container background color field.
	 */
	public function get_sticky_container_bg() {

		$field_id   = 'afs_sticky_container_bg'; // change the id.
		$field_name = $this->options_id . "[{$field_id}]";
		$value      = $this->options[ $field_id ] ?? '#2c2c2c'; // change default value.

		echo $this->get_text_field( $field_name, $field_id, $value, '', 'small-text' ); //phpcs:ignore
	}


	/**
	 * Get search window background color field.
	 */
	public function get_search_window_color() {

		$field_id   = 'afs_search_window_color'; // change the id.
		$field_name = $this->options_id . "[{$field_id}]";
		$value      = $this->options[ $field_id ] ?? '#3498DB'; // change default value.

		echo $this->get_text_field( $field_name, $field_id, $value, '', 'small-text' ); //phpcs:ignore
	}

	/**
	 * Get search window in animation field.
	 */
	public function get_search_window_in() {

		$options = [
			'bounce'            => 'bounce',
			'bounceIn'          => 'bounce In',
			'bounceInDown'      => 'bounce In Down',
			'bounceInLeft'      => 'bounce In Left',
			'bounceInRight'     => 'bounce In Right',
			'bounceInUp'        => 'bounce In Up',
			'fadeIn'            => 'fadeIn',
			'fadeInDown'        => 'fade In Down',
			'fadeInDownBig'     => 'fade In Down Big',
			'fadeInLeft'        => 'fade In Left',
			'fadeInLeftBig'     => 'fade In LeftBig',
			'fadeInRight'       => 'fade In Right',
			'fadeInRightBig'    => 'fade In Right Big',
			'fadeInUp'          => 'fade In Up',
			'fadeInUpBig'       => 'fade In UpBig',
			'flip'              => 'flip',
			'flipInX'           => 'flip In X',
			'flipInY'           => 'flip In Y',
			'lightSpeedIn'      => 'light Speed In',
			'rotateIn'          => 'rotate In',
			'rotateInDownLeft'  => 'rotate In Down Left',
			'rotateInDownRight' => 'rotate In Down Right',
			'rotateInUpLeft'    => 'rotate In Up Left',
			'rotateInUpRight'   => 'rotate In Up Right',
			'slideInUp'         => 'slide In Up',
			'slideInDown'       => 'slide In Down',
			'slideInLeft'       => 'slide In Left',
			'slideInRight'      => 'slide In Right',
			'zoomIn'            => 'zoom In',
			'zoomInDown'        => 'zoom In Down',
			'zoomInLeft'        => 'zoom In Left',
			'zoomInRight'       => 'zoom In Right',
			'zoomInUp'          => 'zoom In Up',
			'hinge'             => 'hinge',
			'rollIn'            => 'roll In',
		];

		$field_id   = 'afs_window_in_animation'; // change the id.
		$field_name = $this->options_id . "[{$field_id}]";
		$value      = $this->options[ $field_id ] ?? ''; // change default value.

		echo $this->get_select_field( $field_name, $field_id, $options, $value  ); //phpcs:ignore

	}

	/**
	 * Get search window out animation field.
	 */
	public function get_search_window_out() {

		$options = [
			'bounce'             => 'bounce',
			'bounceOut'          => 'bounce Out',
			'bounceOutDown'      => 'bounce Out Down',
			'bounceOutLeft'      => 'bounce Out Left',
			'bounceOutRight'     => 'bounce Out Right',
			'bounceOutUp'        => 'bounce Out Up',
			'fadeOut'            => 'fade Out',
			'fadeOutDown'        => 'fade Out Down',
			'fadeOutDownBig'     => 'fade Out Down Big',
			'fadeOutLeft'        => 'fade Out Left',
			'fadeOutLeftBig'     => 'fade Out Left Big',
			'fadeOutRight'       => 'fade Out Right',
			'fadeOutRightBig'    => 'fade Out Right Big',
			'fadeOutUp'          => 'fade Out Up',
			'fadeOutUpBig'       => 'fade Out Up Big',
			'flip'               => 'flip',
			'flipOutX'           => 'flip Out X',
			'flipOutY'           => 'flip Out Y',
			'lightSpeedOut'      => 'light Speed Out',
			'rotateOut'          => 'rotate Out',
			'rotateOutDownLeft'  => 'rotate Out Down Left',
			'rotateOutDownRight' => 'rotate Out Down Right',
			'rotateOutUpLeft'    => 'rotate Out Up Left',
			'rotateOutUpRight'   => 'rotate Out Up Right',
			'slideOutUp'         => 'slide Out Up',
			'slideOutDown'       => 'slide Out Down',
			'slideOutLeft'       => 'slide Out Left',
			'slideOutRight'      => 'slide Out Right',
			'zoomOut'            => 'zoom Out',
			'zoomOutDown'        => 'zoom Out Down',
			'zoomOutLeft'        => 'zoom Out Left',
			'zoomOutRight'       => 'zoom Out Right',
			'zoomOutUp'          => 'zoom Out Up',
			'hinge'              => 'hinge',
			'rollOut'            => 'rollOut',
		];

		$field_id   = 'afs_window_out_animation'; // change the id.
		$field_name = $this->options_id . "[{$field_id}]";
		$value      = $this->options[ $field_id ] ?? ''; // change default value.

		echo $this->get_select_field( $field_name, $field_id, $options, $value  ); //phpcs:ignore

	}

	/**
	 * Get FAQ pagination field.
	 */
	public function get_faq_per_page() {

		$field_id   = 'afs_faq_per_page'; // change the id.
		$field_name = $this->options_id . "[{$field_id}]";
		$value      = $this->options[ $field_id ] ?? 5; // change default value.

		echo $this->get_text_field( $field_name, $field_id, ( intval($value) === 0 ) ? 5: $value  , '', 'small-text' ); //phpcs:ignore
	}

	/**
	 * Get suggestion box background color field.
	 */
	public function get_sugg_box_container_bg() {

		$field_id   = 'afs_sugg_box_container_bg'; // change the id.
		$field_name = $this->options_id . "[{$field_id}]";
		$value      = $this->options[ $field_id ] ?? '#2c2c2c'; // change default value.

		echo $this->get_text_field( $field_name, $field_id, $value, '', 'small-text' ); //phpcs:ignore

	}

	/**
	 * Get suggestion box text color field.
	 */
	public function get_sugg_box_text_color() {

		$field_id   = 'afs_sugg_box_text_color'; // change the id.
		$field_name = $this->options_id . "[{$field_id}]";
		$value      = $this->options[ $field_id ] ?? '#FFFFFF'; // change default value.

		echo $this->get_text_field( $field_name, $field_id, $value, '', 'small-text' ); //phpcs:ignore

	}

	/**
	 * Get suggestion box text hover color field.
	 */
	public function get_sugg_box_text_hover_color() {
		$field_id   = 'afs_sugg_box_text_hover_color'; // change the id.
		$field_name = $this->options_id . "[{$field_id}]";
		$value      = $this->options[ $field_id ] ?? '#F3F3F3'; // change default value.

		echo $this->get_text_field( $field_name, $field_id, $value, '', 'small-text' ); //phpcs:ignore

	}
}
