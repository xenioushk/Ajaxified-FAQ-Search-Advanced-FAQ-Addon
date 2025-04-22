<?php
namespace FTFWCWP\Callbacks\OptionsPanel\RenderFields;

use FTFWCWP\Helpers\PluginConstants;
use FTFWCWP\Traits\OptionsFieldsTraits;

/**
 * Class for rendering the fields.
 *
 * @package FTFWCWP
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
		$this->options_id = FTFWCWP_OPTIONS_ID; // change here.
	}

	/**
	 * Tab title field.
	 */
	public function get_tab_title() {

		$field_id   = 'faqftw_tab_title'; // change the id.
		$field_name = $this->options_id . "[{$field_id}]";
		$value      = $this->options[ $field_id ] ?? esc_html__( 'FAQ', 'baf-faqtfw' ); // change default value.

		echo $this->get_text_field( $field_name, $field_id, $value ); //phpcs:ignore
	}

	/**
	 * Tab position field.
	 */
	public function get_tab_position() {

		$field_id   = 'faqftw_tab_position'; // change the id.
		$field_name = $this->options_id . "[{$field_id}]";
		$value      = $this->options[ $field_id ] ?? 100; // change default value.
		$hints      = esc_html__( 'Set number like- 1,2,3. Set big number(100, 200, 300) to display FAQ tab at the last of tab contain.', 'baf-faqtfw' );

		echo $this->get_text_field( $field_name, $field_id, ( intval($value) === 0 ) ? 100: $value, '', 'small-text', $hints ); //phpcs:ignore
	}

	/**
	 * Tab counter field.
	 */
	public function get_faq_counter() {

		$field_id   = 'faqftw_faq_counter'; // change the id.
		$field_name = $this->options_id . "[{$field_id}]";
		$value      = $this->options[ $field_id ] ?? 1; // change default value.
		$hints      = esc_html__( 'Show total number of FAQ items.', 'baf-faqtfw' );

		echo $this->get_select_field( $field_name, $field_id, $this->get_boolean_dropdown_options(), $value, $hints  ); //phpcs:ignore
	}


	/**
	 * Tab auto hide field.
	 */
	public function get_auto_hide_tab() {

		$field_id   = 'faqftw_auto_hide_tab'; // change the id.
		$field_name = $this->options_id . "[{$field_id}]";
		$value      = $this->options[ $field_id ] ?? 0; // change default value.

		echo $this->get_select_field( $field_name, $field_id, $this->get_boolean_dropdown_options(), $value  ); //phpcs:ignore
	}

	/**
	 * Tab search box field.
	 */
	public function get_show_search_box() {

		$field_id   = 'faqftw_show_search_box'; // change the id.
		$field_name = $this->options_id . "[{$field_id}]";
		$value      = $this->options[ $field_id ] ?? 1; // change default value.

		echo $this->get_select_field( $field_name, $field_id, $this->get_boolean_dropdown_options(), $value  ); //phpcs:ignore
	}

	/**
	 * Tab voting box field.
	 */
	public function get_show_voting_box() {

		$field_id   = 'faqftw_show_voting_box'; // change the id.
		$field_name = $this->options_id . "[{$field_id}]";
		$value      = $this->options[ $field_id ] ?? 1; // change default value.

		echo $this->get_select_field( $field_name, $field_id, $this->get_boolean_dropdown_options(), $value  ); //phpcs:ignore
	}

	/**
	 * Tab meta box field.
	 */
	public function get_show_meta_box() {

		$field_id   = 'faqftw_show_meta_box'; // change the id.
		$field_name = $this->options_id . "[{$field_id}]";
		$value      = $this->options[ $field_id ] ?? 1; // change default value.

		echo $this->get_select_field( $field_name, $field_id, $this->get_boolean_dropdown_options(), $value  ); //phpcs:ignore
	}

	/**
	 * Tab pagination field.
	 */
	public function get_enable_pagination() {

		$field_id   = 'faqftw_enable_pagination'; // change the id.
		$field_name = $this->options_id . "[{$field_id}]";
		$value      = $this->options[ $field_id ] ?? 1; // change default value.

		echo $this->get_select_field( $field_name, $field_id, $this->get_boolean_dropdown_options(), $value  ); //phpcs:ignore
	}

	/**
	 * FAQ item per page field.
	 */
	public function get_item_per_page() {

		$field_id   = 'faqftw_item_per_page'; // change the id.
		$field_name = $this->options_id . "[{$field_id}]";
		$value      = $this->options[ $field_id ] ?? 5; // change default value.

		echo $this->get_text_field( $field_name, $field_id, ( intval($value) === 0 ) ? 5: $value  , '', 'small-text' ); //phpcs:ignore
	}
}
