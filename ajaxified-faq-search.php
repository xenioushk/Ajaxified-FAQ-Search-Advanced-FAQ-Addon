<?php

/**
 * Plugin Name: Ajaxified FAQ Search - Advanced FAQ Addon
 * Plugin URI: https://bluewindlab.net
 * Description: The Ajaxified FAQ Search is an add-on specifically designed for the BWL Advanced FAQ Manager plugin. This add-on enhances the functionality of the FAQ Manager by introducing a quick and efficient way to search for frequently asked questions.
 * Author: Md Mahbub Alam Khan
 * Version: 1.1.2
 * Author URI: https://bluewindlab.net
 * WP Requires at least: 5.6+
 * Text Domain: afs-addon
 */

class BAF_AFS_Manager
{

    function __construct()
    {

        $baf_afs_compatibily_status = $this->baf_afs_compatibily_status();

        // If plugin is not compatible then display a notice in admin panel.
        if ($baf_afs_compatibily_status == 0 && is_admin()) {

            add_action('admin_notices', [$this, 'baf_afs_requirement_admin_notices']);
        }

        //If plugin is compatible then load all require files.
        if ($baf_afs_compatibily_status == 1) {

            define("AFS_PLUGIN_VERSION", '1.1.2');
            define("AFS_PLUGIN_UPDATER_SLUG", plugin_basename(__FILE__)); // change plugin current version in here.
            define("AFS_PLUGIN_CC_ID", "12033214"); // Plugin codecanyon Id.
            define('AFS_PLUGIN_INSTALLATION_TAG', 'baf_afs_installation_' . str_replace('.', '_', AFS_PLUGIN_VERSION));

            $this->included_files();
            add_action('wp_enqueue_scripts', [&$this, 'afs_enqueue_plugin_scripts']);
            add_action('admin_enqueue_scripts', [&$this, 'afs_admin_enqueue_plugin_scripts']);
            $this->plugin_name_load_plugin_textdomain();
        }
    }

    function plugin_name_load_plugin_textdomain()
    {

        $domain = 'afs-addon';

        load_plugin_textdomain($domain, FALSE, dirname(plugin_basename(__FILE__)) . '/lang/');
    }

    function baf_afs_compatibily_status()
    {

        include_once(ABSPATH . 'wp-admin/includes/plugin.php');

        $current_version = get_option('bwl_advanced_faq_version');

        if ($current_version == "") {
            $current_version = '1.5.7';
        }

        if (class_exists('BWL_Advanced_Faq_Manager') && $current_version > '1.5.7') {

            return 1; // Parent FAQ Plugin has been installed & activated.

        } else {

            return 0; // Parent FAQ Plugin is not installed or activated.

        }
    }

    function baf_afs_requirement_admin_notices()
    {
        echo '<div class="updated"><p>You need to download & install '
            . '<b><a href="https://1.envato.market/baf-wp" target="_blank">BWL Advanced FAQ Manager Plugin</a></b> '
            . 'to use <b>Ajaxified FAQ Search - Advanced FAQ Addon</b>. Minimum version <b>1.5.7</b> required ! </p></div>';
    }

    function included_files()
    {

        if (is_admin()) {

            include_once dirname(__FILE__) . '/includes/settings/afs-admin-settings.php'; // Load plugins option panel.
            require_once(__DIR__ . '/includes/autoupdater/WpAutoUpdater.php');
            require_once(__DIR__ . '/includes/autoupdater/installer.php');
            require_once(__DIR__ . '/includes/autoupdater/updater.php');
        } else {

            include_once dirname(__FILE__) . '/includes/afs-custom-theme.php';
            include_once dirname(__FILE__) . '/includes/afs-helpers.php';
            include_once dirname(__FILE__) . '/includes/shortcode/afs-shortcodes.php';
        }

        include_once dirname(__FILE__) . '/includes/afs-ajax-search.php';
    }

    function afs_enqueue_plugin_scripts()
    {

        wp_enqueue_style('afs-simple-popup', plugins_url('libs/jquery.simple.popup/styles/popup.css', __FILE__), [], AFS_PLUGIN_VERSION);
        wp_enqueue_style('afs-animate', plugins_url('libs/animate/styles/animate.min.css', __FILE__), [], AFS_PLUGIN_VERSION);
        wp_enqueue_style('afs-frontend', plugins_url('assets/styles/frontend.css', __FILE__), [], AFS_PLUGIN_VERSION);

        if (is_rtl()) {
            wp_enqueue_style('afs-frontend-rtl', plugins_url('assets/styles/frontend_rtl.css', __FILE__), [], AFS_PLUGIN_VERSION);
        }

        wp_register_script('afs-animate-modal', plugins_url('libs/animated.modal/scripts/animatedModal.min.js', __FILE__), ['jquery'], AFS_PLUGIN_VERSION, TRUE);
        wp_enqueue_script('afs-frontend', plugins_url('assets/scripts/frontend.js', __FILE__), ['jquery', 'afs-animate-modal'], AFS_PLUGIN_VERSION, TRUE);
    }

    function afs_admin_enqueue_plugin_scripts()
    {
        wp_register_script('afs-admin', plugins_url('assets/scripts/admin.js', __FILE__), ['jquery', 'wp-color-picker'], AFS_PLUGIN_VERSION, TRUE);

        wp_localize_script(
            'afs-admin',
            'BafAfsAdminData',
            [
                'product_id' => AFS_PLUGIN_CC_ID,
                'installation' => get_option(AFS_PLUGIN_INSTALLATION_TAG)
            ]
        );
    }
}

/*---Initialization---*/

function init_baf_ajaxified_search()
{
    new BAF_AFS_Manager();
}

add_action('init', 'init_baf_ajaxified_search');

function template_chooser($template)
{
    global $wp_query, $post;
    $plugindir = dirname(__FILE__);
    $post_type = get_query_var('post_type');
    if ($wp_query->is_search && $post_type == 'bwl_advanced_faq') {
        return locate_template('bwl_advanced_faq-search.php');  //  redirect to archive-search.php
    }
    return $template;
}

add_filter('template_include', 'template_chooser');
