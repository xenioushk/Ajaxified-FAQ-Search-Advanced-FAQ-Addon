<?php

/**
 * Plugin Name: Ajaxified FAQ Search - Advanced FAQ Addon
 * Plugin URI: https://codecanyon.net/item/ajaxified-faq-search-advanced-faq-addon/12033214?ref=xenioushk
 * Description: Ajaxified FAQ Search is a premium addon for BWL Advanced FAQ Manager that allows you to search FAQ quickly in modal window.
 * Author: Md Mahbub Alam Khan
 * Version: 1.0.7
 * Author URI: http://codecanyon.net/user/xenioushk?ref=xenioushk
 * WP Requires at least: 4.8+
 * Text Domain: afs-addon
 */

class BAF_AFS_Manager
{

    function __construct()
    {

        $baf_afs_compatibily_status = $this->baf_afs_compatibily_status();

        // If plugin is not compatible then display a notice in admin panel.
        if ($baf_afs_compatibily_status == 0 && is_admin()) {

            add_action('admin_notices', array($this, 'baf_afs_requirement_admin_notices'));
        }

        //If plugin is compatible then load all require files.

        if ($baf_afs_compatibily_status == 1) {

            define("AFS_PLUGIN_VERSION", '1.0.7');
            $this->included_files();
            add_action('wp_enqueue_scripts', array(&$this, 'afs_enqueue_plugin_scripts'));
            add_action('admin_enqueue_scripts', array(&$this, 'afs_admin_enqueue_plugin_scripts'));
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

        } else {

            include_once dirname(__FILE__) . '/includes/afs-custom-theme.php';
            include_once dirname(__FILE__) . '/includes/afs-helpers.php';
            include_once dirname(__FILE__) . '/shortcode/afs-shortcodes.php';
        }

        include_once dirname(__FILE__) . '/includes/afs-ajax-search.php';
    }

    function afs_enqueue_plugin_scripts()
    {

        wp_enqueue_style('afs-popup-styles', plugins_url('css/jquery.simple-popup.css', __FILE__), array(), AFS_PLUGIN_VERSION);
        wp_enqueue_style('afs-animate-styles', plugins_url('css/animate.min.css', __FILE__), array(), AFS_PLUGIN_VERSION);
        wp_enqueue_style('afs-custom-styles', plugins_url('css/afs-custom-styles.css', __FILE__), array(), AFS_PLUGIN_VERSION);

        if (is_rtl()) {

            wp_register_style('afs-rtl-style', plugin_dir_url(__FILE__) . 'css/afs-rtl-styles.css', array(), AFS_PLUGIN_VERSION);
            wp_enqueue_style('afs-rtl-style');
        }




        wp_register_script('afs-custom-search-script', plugins_url('js/afs-search-scripts.js', __FILE__), array('jquery', 'baf_pagination'), AFS_PLUGIN_VERSION, TRUE);
        wp_register_script('afs-animate-script', plugins_url('js/animatedModal.min.js', __FILE__), array('jquery'), AFS_PLUGIN_VERSION, TRUE);
        wp_register_script('afs-custom-script', plugins_url('js/afs-custom.js', __FILE__), array('jquery', 'afs-animate-script'), AFS_PLUGIN_VERSION, TRUE);
    }

    function afs_admin_enqueue_plugin_scripts()
    {
        wp_register_script('afs-admin-custom-script', plugins_url('js/afs-admin-custom.js', __FILE__), array('jquery', 'wp-color-picker'), AFS_PLUGIN_VERSION, TRUE);
        wp_enqueue_script('afs-admin-custom-script');
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