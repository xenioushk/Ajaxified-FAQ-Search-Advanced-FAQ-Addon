<?php
namespace FTFWCWP\Callbacks\Filters;

/**
 * Class for registering tab content filter.
 *
 * @package FTFWCWP
 * @since: 1.0.0
 * @author: Mahbub Alam Khan
 */
class TabContentFilterCb {

	/**
	 * Modify content.
	 *
	 * @param array $field_value The field value.
	 * @return array
	 */
	public function modify_content( $field_value ) {

		if ( isset( $field_value[0] ) && is_array( $field_value[0] ) && ! empty( $field_value[0] ) ) {

			return $field_value[0]; // for new version

		} elseif ( isset( $field_value ) && is_array( $field_value ) && ! empty( $field_value ) ) {

			return $field_value; // for old version
		} else {

			return []; // return nothing.

		}
	}
}
