<?php
namespace AFSADDONWP\Controllers\OptionsPanel;

use AFSADDONWP\Callbacks\OptionsPanel\SettingsPageCb;
use AFSADDONWP\Callbacks\OptionsPanel\FieldsSettings\DisplayFieldsCb;

/**
 * Class for the plugin settings page.
 *
 * @package AFSADDONWP
 * @since: 1.0.0
 */
class SettingsPage {

    /**
     * Plugin options id.
     *
     * @note: Must be unqiue, and we will fetch data using this id.
     * @var string
     */
    public $options_id = AFSADDONWP_OPTIONS_ID;

    /**
     * Plugin page id.
     *
     * @note: Must be unique.
     * @var string
     */
    public $options_page_id = 'afs-settings';

    /**
     * Settings fields.
     *
     * @var array
     */
    public $settings_fields = [];

    /**
     * Register the settings page and fields
     */
	public function register() {
        $this->initialize();
	}

    /**
     * Initialize the settings page and fields
     */
    public function initialize() {
        // Initialize the settings page.
        add_action( 'admin_menu',  [ $this, 'register_options_page' ] );
		add_action( 'admin_init',  [ $this, 'register_settings_fields' ] );
    }

    /**
     * Register options page to the parent menu.
     * For this we are going to add the submenu page to the BWL Advanced FAQ menu.
     */
	public function register_options_page() {
		// Initalize Callbacks.
		$settings_page_cb = new SettingsPageCb();

		add_submenu_page(
            'edit.php?post_type=bwl_advanced_faq',
            'Ajaxified FAQ Search Settings',
            'Ajaxified Search',
            'manage_options',
            $this->options_page_id,
            [ $settings_page_cb, 'load_template' ]
		);
	}

    /**
     * Display the settings section
     */
	public function afs_display_section_cb() {
        return '';
	}

    /**
     * Register the options group
     */
    public function register_options_group() {
        // We will keep the group name same as the options id.
        // This group name should be the into the settings_page_tpl.php file
        // settings_fields( $options_id ); // Matches the group name.
		register_setting( $this->options_id, $this->options_id );
    }

    /**
     * Register the settings fields
     *
     * @note: Register sections here.
     */
	public function register_settings_fields() {

        // Register Options Group.
        $this->register_options_group();

        // Register Sections.
        // You can register multiple sections here.
        // Each section must be an array with a unique id.
        $sections = [
            'afs_display_section' => [
				'title'    => esc_html__( 'Display Settings:', 'baf-faqtfw' ),
				'callback' => [ $this, 'afs_display_section_cb' ],
            ],
        ];

        foreach ( $sections as $section_id => $section ) {
            add_settings_section(
                $section_id,
                $section['title'],
                $section['callback'],
                $this->options_page_id
            );
            $this->register_fields( $section_id );
        }
	}

    /**
     * Set the fields for the settings page
     *
     * @param string $section_id The section id to get the fields from.
     * @note: Add a new case for new section. Also register callback function for the new section.
     *
     * @return array The fields for the settings page.
     */
    public function get_fields( $section_id ) {
        switch ( $section_id ) {
            case 'afs_display_section':
                return ( new DisplayFieldsCb() )->get_fields();
			default:
                return [];
        }
    }

    /**
     * Register the fields for the settings page
     *
     * @param string $section_id The section id to register the fields to.
     * @note: No need to change this function.
     */
    public function register_fields( $section_id = '' ) {

        if ( empty( $section_id ) ) {
            return;
        }

        $settings_fields = $this->get_fields( $section_id );

        if ( empty( $settings_fields ) ) {
            echo "Empty settings fields for section: {$section_id}"; //phpcs:ignore
            exit();
        }

		foreach ( $settings_fields as $id => $field ) {
			add_settings_field(
				$id,
				$field['title'],
				$field['callback'],
				$this->options_page_id,
				$section_id,
			);
		}
    }
}
