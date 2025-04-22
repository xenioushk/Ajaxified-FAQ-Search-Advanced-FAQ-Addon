<?php
namespace FTFWCWP\Controllers\Cmb;

/**
 * Class for Initialize plugin custom meta box.
 *
 * @since: 1.1.0
 * @package FTFWCWP
 */
class BafCmbFramework {

    /**
     * Custom fields data.
     *
     * @var array
     */
    public $custom_fields = [];

    /**
     * Constructor.
     *
     * @param array $custom_fields Custom fields data.
     */
    public function __construct( $custom_fields ) {

        $this->custom_fields = $custom_fields; // Set custom field data as global value.

        add_action( 'add_meta_boxes', [ $this, 'register_metaboxes' ] );
        add_action( 'save_post_product', [ $this, 'save_cmb_data' ] );
    }

    /**
     * Register the meta boxes.
     *
     * @return void
     */
    public function register_metaboxes() {

        $fields = $this->custom_fields;

        add_meta_box(
            $fields['meta_box_id'],
            $fields['meta_box_heading'],
            [ $this, 'show_meta_box' ],
            $fields['post_type'],
            $fields['context'],
            $fields['priority']
        );
    }

    public function show_meta_box( $post ) {

        $bwl_cmb_custom_fields = $this->custom_fields;

        foreach ( $bwl_cmb_custom_fields['fields'] as $custom_field ) :

            $field_value = get_post_meta( $post->ID, $custom_field['id'], true );
			?>

			<?php if ( $custom_field['type'] == 'text' ) : ?>

<p class="bwl_cmb_row">
    <label for="<?php echo $custom_field['id']; ?>"><?php echo $custom_field['title']; ?> </label>
    <input type="<?php echo $custom_field['type']; ?>" id="<?php echo $custom_field['id']; ?>"
    name="<?php echo $custom_field['name']; ?>" class="<?php echo $custom_field['class']; ?>"
    value="<?php echo esc_attr( $field_value ); ?>" />
</p>

			<?php endif; ?>

			<?php if ( $custom_field['type'] == 'select' ) : ?>

				<?php
                $values = get_post_custom( $post->ID );

                $selected = isset( $values[ $custom_field['name'] ] ) ? esc_attr( $values[ $custom_field['name'] ][0] ) : $custom_field['default_value'];
				?>

<p class="bwl_cmb_row">
    <label for="<?php echo $custom_field['id']; ?>"><?php echo $custom_field['title']; ?> </label>
    <select name="<?php echo $custom_field['name']; ?>" id="<?php echo $custom_field['id']; ?>">

    <option value="" selected="selected">- Select -</option>

				<?php foreach ( $custom_field['value'] as $key => $value ) : ?>
    <option value="<?php echo $key; ?>" <?php selected( $selected, $key ); ?>><?php echo $value; ?></option>
    <?php endforeach; ?>

    </select>

				<?php if ( isset( $custom_field['desc'] ) && $custom_field['desc'] != '' ) { ?>
    <i><?php echo $custom_field['desc']; ?></i>
    <?php } ?>
</p>

			<?php endif; ?>

			<?php if ( $custom_field['type'] == 'repeatable_select' ) : ?>

<p class="bwl_cmb_row bwl_cmb_db">
    <label for="<?php echo $custom_field['id']; ?>"><?php echo $custom_field['title']; ?>: </label>

				<?php if ( isset( $custom_field['desc'] ) && $custom_field['desc'] != '' ) : ?>
    <small class="small-text"><?php echo $custom_field['desc']; ?></small>
    <?php endif; ?>
</p>
<textarea id="bwl_cmb_data_set"
    style="display: none;"><?php echo json_encode( $custom_field['default_value'] ); ?></textarea>

<ul class="bwl_cmb_repeat_field_container">

				<?php
                    $i           = 0;
                    $field_value = apply_filters( 'filter_baftfwc_content_data', get_post_meta( $post->ID, $custom_field['id'] ) );

				if ( ! empty( $field_value ) && is_array( $field_value ) ) {

					foreach ( $field_value as $db_save_key => $db_save_value ) {

						// Find Current Selected Field.
						?>

    <li class="bwl_cmb_repeat_row" data-row_count="<?php echo $i; ?>">

						<?php
						if ( ! empty( $custom_field['label_text'] ) ) {
							echo "<span class='label'>" . $custom_field['label_text'] . '</span>';
						}
						?>

    <select id="<?php echo $custom_field['id'] . '_' . $i; ?>"
        name="<?php echo $custom_field['name'] . '[' . $i . ']'; ?>">

        <option value="" selected="selected"><?php esc_html_e( '- Select -', 'baf-faqtfw' ); ?></option>

						<?php foreach ( $custom_field['default_value'] as $default_key => $default_value ) : ?>
        <option value="<?php echo $default_key; ?>"
							<?php echo ( $db_save_value == $default_key ) ? 'selected=selected' : ''; ?>><?php echo $default_value; ?>
        </option>
        <?php endforeach; ?>

    </select>

    <a class="delete_row"
        title="<?php esc_html_e( 'Delete', 'baf-faqtfw' ); ?>"><?php esc_html_e( 'Delete', 'baf-faqtfw' ); ?></a>
    </li>

						<?php
						++$i;
					}
				}
				?>
</ul>

<input id="add_new_row" type="button" class="button" value="<?php echo $custom_field['btn_text']; ?>"
    data-delete_text="<?php esc_html_e( 'Delete', 'baf-faqtfw' ); ?>"
    data-upload_text="<?php esc_html_e( 'Upload', 'baf-faqtfw' ); ?>"
    data-field_type="<?php echo $custom_field['type']; ?>" data-field_name="<?php echo $custom_field['name']; ?>"
    data-label_text="<?php echo $custom_field['label_text']; ?>">


			<?php endif; ?>

			<?php
        endforeach;
    }

    public function save_cmb_data( $id ) {

        global $post;

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {

            return $id;
        } else {

            $baf_wc_meta_custom_fields = $this->custom_fields;

            $baf_wc_excluded_fileds = [ 'faqftw_faq_post_ids' ];

            foreach ( $baf_wc_meta_custom_fields['fields'] as $custom_field ) {

                if ( isset( $_POST[ $custom_field['name'] ] ) ) {

                    // Updated in version 1.1.2

                    if ( ! in_array( $custom_field['name'], $baf_wc_excluded_fileds ) ) {

                        update_post_meta( $id, $custom_field['name'], strip_tags( $_POST[ $custom_field['name'] ] ) );
                    }
                }
            }

            // Repeatable KB Select Fields Data Saving In Here.
            // Introduced in version 1.1.2

            if ( isset( $_POST['faqftw_faq_post_ids'] ) ) {

                $faqftw_count_prev_post_meta = get_post_meta( $id, 'faqftw_faq_post_ids' );

                if ( count( $faqftw_count_prev_post_meta ) > 1 ) {
                    // remove old meta fields and then update data.
                    delete_post_meta( $id, 'faqftw_faq_post_ids' );
                }

                update_post_meta( $id, 'faqftw_faq_post_ids', $_POST['faqftw_faq_post_ids'] );
            } elseif ( isset( $_POST['action'] ) && $_POST['action'] != 'inline-save' ) {

                delete_post_meta( $id, 'faqftw_faq_post_ids' );
            }
        }
    }
}
