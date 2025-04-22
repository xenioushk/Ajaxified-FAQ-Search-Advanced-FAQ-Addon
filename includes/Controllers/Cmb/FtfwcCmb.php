<?php
namespace FTFWCWP\Controllers\Cmb;

use FTFWCWP\Controllers\Cmb\BafCmbFramework;

use WP_Query;

/**
 * Class for registering CMB for the plugin.
 *
 * @since: 1.1.0
 * @package FTFWCWP
 */
class FtfwcCmb {

    /**
     * Post ids.
     *
     * @var array
     */
    private $post_ids = [];


    /**
     * Constructor for the class.
     */
    public function __construct() {
        $this->set_post_ids();
    }

    /**
     * Register the cmb.
     */
    public function register() {
        add_action( 'admin_init',  [ $this, 'init_cmb' ] );
    }

    /**
     * Initialize the cmb.
     *
     * @note: This method will register the cmb for the plugin.
     */
    public function init_cmb() {

        $cmb_fields = [
            'meta_box_id'      => 'cmb_bkb_woo_item_settings', // Unique id of meta box.
            'meta_box_heading' => 'FAQ Item Settings', // That text will be show in meta box head section.
            'post_type'        => 'product', // define post type. go to register_post_type method to view post_type name.
            'context'          => 'normal',
            'priority'         => 'high',
            'fields'           => [
                'baf_woo_tab_hide_status' => [
                    'title'         => esc_html__( 'Hide FAQ Tab?', 'baf-faqtfw' ),
                    'id'            => 'baf_woo_tab_hide_status',
                    'name'          => 'baf_woo_tab_hide_status',
                    'type'          => 'select',
                    'value'         => [
                        '1' => esc_html__( 'Yes', 'baf-faqtfw' ),
                        '2' => esc_html__( 'No', 'baf-faqtfw' ),
                    ],
                    'default_value' => 2,
                    'class'         => 'widefat',
                ],
                'faqftw_faq_post_ids' => [
                    'title'         => esc_html__( 'Add FAQ Items', 'baf-faqtfw' ),
                    'id'            => 'faqftw_faq_post_ids',
                    'name'          => 'faqftw_faq_post_ids',
                    'type'          => 'repeatable_select',
                    'value'         => '',
                    'default_value' => $this->post_ids,
                    'class'         => 'widefat',
                    'btn_text'      => esc_html__( 'Add New FAQ', 'baf-faqtfw' ),
                    'label_text'    => '',
                    'field_type'    => 'select',
                ],
            ],
        ];

        new BafCmbFramework( $cmb_fields );
    }

    /**
     * Set post ids.
     *
     * @return void
     */
    private function set_post_ids() {
        $args = [
            'post_status'    => 'publish',
            'post_type'      => BAF_POST_TYPE,
            'orderby'        => 'title',
            'order'          => 'ASC',
            'posts_per_page' => -1,
        ];

        $loop = new WP_Query( $args );

        $post_ids = [];

        if ( $loop->have_posts() ) :

            while ( $loop->have_posts() ) :

                $loop->the_post();

                $post_ids[ get_the_ID() ] = ucfirst( get_the_title() );

            endwhile;

        endif;

        wp_reset_postdata();

        $this->post_ids = $post_ids;
    }
}
