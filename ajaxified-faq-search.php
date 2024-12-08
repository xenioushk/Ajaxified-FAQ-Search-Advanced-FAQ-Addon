<?php

/**
 * Plugin Name: Ajaxified FAQ Search - Advanced FAQ Addon
 * Plugin URI: https://bluewindlab.net/portfolio/ajaxified-faq-search-advanced-faq-addon/
 * Description: The Ajaxified FAQ Search is an add-on specifically designed for the BWL Advanced FAQ Manager plugin. This add-on enhances the functionality of the FAQ Manager by introducing a quick and efficient way to search for frequently asked questions.
 * Author: Mahbub Alam Khan
 * Version: 1.1.8
 * Author URI: https://codecanyon.net/user/xenioushk
 * WP Requires at least: 6.0+
 * Text Domain: afs-addon
 * Domain Path: /lang/
 * 
 * 
 * @package Ajaxified FAQ Search - Advanced FAQ Addon
 * @author Mahbub Alam Khan
 * @license GPL-2.0+
 * @link https://codecanyon.net/user/xenioushk
 * @copyright 2024 BlueWindLab
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

class BAF_AFS_Manager
{

    function __construct()
    {

        // Constants.
        define("AFS_PARENT_PLUGIN_TITLE", "BWL Advanced FAQ Manager");
        define("AFS_PLUGIN_TITLE", "Ajaxified FAQ Search - Advanced FAQ Addon");
        define("AFS_PLUGIN_VERSION", "1.1.8");
        define("AFS_PLUGIN_UPDATER_SLUG", plugin_basename(__FILE__)); // change plugin current version in here.
        define("AFS_PLUGIN_CC_ID", "12033214"); // Plugin codecanyon Id.
        define('AFS_PLUGIN_INSTALLATION_TAG', 'baf_afs_installation_' . str_replace('.', '_', AFS_PLUGIN_VERSION));

        define("AFS_PARENT_PURCHASE_VERIFIED_KEY", "baf_purchase_verified");

        //Checking plugin compatibility and require parent plugin.
        $compatibilyStatus = $this->baf_afs_compatibily_status();

        // Display a notice if parent plugin is missing.
        if ($compatibilyStatus == 0 && is_admin()) {

            add_action('admin_notices', [$this, 'afsPluginDependenciesNotice']);
            return false;
        }

        // Checking purchase status.
        $purchaseStatus = $this->getPurchaseStatus();

        // Display notice if purchase code is missing.
        if (is_admin() && $purchaseStatus == 0) {

            add_action('admin_notices', array($this, 'bafTplPurchaseVerificationNotice'));
            return false;
        }
        // if the compatibility and purchase code is okay
        // then we will set the status 1.
        $compatibilyStatus = $purchaseStatus ? 1 : 0;

        // Finally, load the required files for the addon.

        if ($compatibilyStatus == 1) {

            $this->included_files();
            add_action('wp_enqueue_scripts', [&$this, 'enqueueScripts']);
            add_action('admin_enqueue_scripts', [&$this, 'enqueueAdminScripts']);
            add_action('plugins_loaded', [$this, 'afsLoadTranslationFile']);
        }
    }

    function afsLoadTranslationFile()
    {
        load_plugin_textdomain('afs-addon', FALSE, dirname(plugin_basename(__FILE__)) . '/lang/');
    }

    function baf_afs_compatibily_status()
    {
        if (class_exists('BWL_Advanced_Faq_Manager')) {

            return 1; // Parent FAQ Plugin has been installed & activated.

        } else {

            return 0; // Parent FAQ Plugin is not installed or activated.

        }
    }

    function afsPluginDependenciesNotice()
    {
        echo '<div class="notice notice-error"><p>You need to download & install '
            . '<b><a href="https://1.envato.market/baf-wp" target="_blank">' . AFS_PARENT_PLUGIN_TITLE . '</a></b> plugin '
            . 'to use <b>' . AFS_PLUGIN_TITLE . '</b>.</p></div>';
    }

    /**
     * Check the purchase status.
     * @since: 1.1.7
     * @return bool
     */
    public function getPurchaseStatus()
    {
        return get_option(AFS_PARENT_PURCHASE_VERIFIED_KEY) == 1 ? 1 : 0;
    }

    /**
     * Display prompt notice to verify license.
     * @since: 1.1.7
     * @return string
     */

    public function bafTplPurchaseVerificationNotice()
    {
        $licensePage = admin_url("admin.php?page=baf-license");

        echo '<div class="notice notice-error"><p class="bwl_plugins_notice_text">
        <span class="dashicons dashicons-lock bwl_plugins_notice_text--danger"></span> 
        You need to <a href="' . $licensePage . '" class="bwl_plugins_notice_text--danger bwl_plugins_notice_text--bold">ACTIVATE</a> the '
            . '<b>' . AFS_PARENT_PLUGIN_TITLE . '</b> plugin '
            . 'to use <b>' . AFS_PLUGIN_TITLE . '</b>. </p></div>';
    }

    /**
     * Include addon required files.
     * @since: 1.0.0
     */

    function included_files()
    {

        if (is_admin()) {

            // Addon Installation Date Time.
            if (empty(get_option("baf_afs_installation_date"))) {
                update_option("baf_afs_installation_date", date("Y-m-d H:i:s"));
            }

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

    /**
     * Include addon front-end scripts.
     * @since: 1.0.0
     */

    function enqueueScripts()
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

    /**
     * Include addon back-end scripts.
     * @since: 1.0.0
     */

    function enqueueAdminScripts()
    {
        wp_enqueue_script('afs-admin', plugins_url('assets/scripts/admin.js', __FILE__), ['jquery', 'wp-color-picker'], AFS_PLUGIN_VERSION, TRUE);

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

// Addon Initialization.

function initBafAfsAddon()
{
    new BAF_AFS_Manager();
}

add_action('init', 'initBafAfsAddon');

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