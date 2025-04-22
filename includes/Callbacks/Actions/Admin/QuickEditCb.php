<?php
namespace FTFWCWP\Callbacks\Actions\Admin;

/**
 * Class for registering the quick edit callback.
 *
 * @package FTFWCWP
 * @since: 1.0.0
 * @author: Mahbub Alam Khan
 */
class QuickEditCb {

	/**
	 * Callback for the quick edit custom box.
	 *
	 * @param string $column_name column name.
	 * @param string $post_type post type.
	 *
	 * @return mixed
	 */
	public function get_edit_box( $column_name, $post_type ) {

		global $post;

		switch ( $post_type ) {

			case $post_type:
				switch ( $column_name ) {

					case 'baf_woo_tab_hide_status':
						$baf_woo_tab_hide_status = ( get_post_meta( $post->ID, 'baf_woo_tab_hide_status', true ) == '' ) ? '' : get_post_meta( $post->ID, 'baf_woo_tab_hide_status', true );
						?>


<fieldset class="inline-edit-col-left">
    <div class="inline-edit-col">
    <div class="inline-edit-group">
        <label class="alignleft">

        <span class="checkbox-title"><?php esc_html_e( 'Hide FAQ Tab?', 'baf-faqtfw' ); ?></span>
        <select name="baf_woo_tab_hide_status">
            <option value="3"><?php esc_html_e( '- No Change -', 'baf-faqtfw' ); ?></option>
            <option value="1"><?php esc_html_e( 'Yes', 'baf-faqtfw' ); ?></option>
            <option value="2"><?php esc_html_e( 'No', 'baf-faqtfw' ); ?></option>
        </select>
        </label>

    </div>
    </div>
</fieldset>


						<?php
	                    break;
				}

                break;
		}
	}
}
