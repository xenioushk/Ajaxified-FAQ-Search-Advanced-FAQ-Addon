<?php

if (!function_exists('afs_custom_theme')) {

    function afs_custom_theme()
    {

        $bwl_advanced_faq_options = get_option('bwl_advanced_faq_options');
        $afs_options = get_option('afs_options');

        $afs_sticky_container_bg = "#2C2C2C";
        $afs_sugg_box_container_bg = "#2C2C2C";
        $afs_sugg_box_text_color = "#FFFFFF";
        $afs_sugg_box_text_hover_color = "#F3F3F3";


        $afs_custom_theme = '<style type="text/css">';

        /*------------------------------ RTL Support For Search Section ---------------------------------*/

        if (is_rtl()) {
            //Write all custom codes for RTL in here.
            $afs_custom_theme .= 'span.afs-btn-clear{ left: 5px;}';
        } else {

            $afs_custom_theme .= 'span.afs-btn-clear{ right: 5px;}';
        }


        if (isset($afs_options['afs_sticky_container_bg']) && $afs_options['afs_sticky_container_bg'] != "") {

            $afs_sticky_container_bg = strtoupper($afs_options['afs_sticky_container_bg']);
        }

        $afs_custom_theme .= 'ul.afs-sticky li{ background: ' . $afs_sticky_container_bg . ';}';

        /*------------------------------  Suggestion Box Background Color ---------------------------------*/

        if (isset($afs_options['afs_sugg_box_container_bg']) && $afs_options['afs_sugg_box_container_bg'] != "") {

            $afs_sugg_box_container_bg = strtoupper($afs_options['afs_sugg_box_container_bg']);
        }

        $afs_custom_theme .= 'div.suggestionsBox{ background: ' . $afs_sugg_box_container_bg . ' !important;}';
        $afs_custom_theme .= 'div.suggestionList:before{ border-bottom: 7px solid ' . $afs_sugg_box_container_bg . ' !important;}';


        /*------------------------------  Suggestion Box Text Color ---------------------------------*/

        if (isset($afs_options['afs_sugg_box_text_color']) && $afs_options['afs_sugg_box_text_color'] != "") {

            $afs_sugg_box_text_color = strtoupper($afs_options['afs_sugg_box_text_color']);
        }

        if (isset($afs_options['afs_sugg_box_text_hover_color']) && $afs_options['afs_sugg_box_text_hover_color'] != "") {

            $afs_sugg_box_text_hover_color = strtoupper($afs_options['afs_sugg_box_text_hover_color']);
        }

        $afs_custom_theme .= 'div.suggestionList ul li a{ color: ' . $afs_sugg_box_text_color . ' !important;}';
        $afs_custom_theme .= 'div.suggestionList ul li a:hover{ color: ' . $afs_sugg_box_text_hover_color . ' !important;}';


        $afs_custom_theme .= '</style>';

        echo $afs_custom_theme;
    }

    add_action('wp_head', 'afs_custom_theme');
}