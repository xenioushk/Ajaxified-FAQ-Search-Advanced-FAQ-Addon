<?php
namespace FTFWCWP\Traits;

trait OptionsFieldsTraits {

	/**
	 * Text field
	 *
	 * @param string $name  The name of the field.
	 * @param string $id    The id of the field.
	 * @param bool   $value The value of the field.
	 * @param string $placeholder Placeholder text.
	 * @param string $class_name The class of the field.
	 * @param string $hints Hints for the field.
	 *
	 * @return string
	 */
	public function get_text_field( $name, $id, $value = '', $placeholder = '', $class_name = 'medium-text', $hints = '' ) {
		return sprintf(
			"<input type='text' name='%s' id='%s' class='%s' value='%s' placeholder='%s' />%s",
			esc_attr( $name ),
			esc_attr( $id ),
			esc_attr( $class_name ),
			esc_attr( $value ),
			esc_attr( $placeholder ),
			( ! empty( $hints ) ) ? $this->get_field_hints( $hints ) : ''
		);
	}

	/**
	 * Select field
	 *
	 * @param string     $name  The name of the field.
	 * @param string     $id    The id of the field.
	 * @param array      $options Default options for the field.
	 * @param string|int $selected The value of the field.
	 * @param string     $hints Hints for the field.
	 *
	 * @return string
	 */
	public function get_select_field( $name, $id, $options = [], $selected = '', $hints = '' ) {

		$options_html = '';

		foreach ( $options as $value => $label ) {
			$options_html .= sprintf(
                "<option value='%s'%s>%s</option>",
                esc_attr( $value ),
                selected( $selected, $value, false ),
                esc_html( $label )
			);
		}

		return sprintf(
			"<select name='%s' id='%s'>%s</select>%s",
			esc_attr( $name ),
			esc_attr( $id ),
			$options_html,
			( ! empty( $hints ) ) ? $this->get_field_hints( $hints ) : ''
		);
	}


	/**
	 * Get field hints
	 *
	 * This function returns the hints for a field.
     *
	 * @param string $hints The hints for the field.
	 *
	 * @return string
	 */
	private function get_field_hints( $hints ) {
		return sprintf(
			'<span class="bwl-opt-tooltip"><i class="dashicons dashicons-info"></i><span class="tooltip-text">%s</span></span>',
			esc_html( $hints )
		);
	}

	/**
	 * Get boolean dropdown options
	 *
	 * This function returns the options for a boolean dropdown field.
     *
	 * @param array $data The data for the field.
	 *
	 * @return array
	 */
	public function get_boolean_dropdown_options( $data = [] ) {

		$options = [
			'1' => esc_html__( 'Yes', 'default' ),
			'0' => esc_html__( 'No', 'default' ),
		];

		if ( ! empty( $data ) ) {
			$options = array_merge( $options, $data );
		}

		return $options;
	}
}
