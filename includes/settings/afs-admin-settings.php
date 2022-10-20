<?php

/**
 * Render the settings screen
 */

function afs_settings()
{

?>

<div class="wrap faq-wrapper baf-option-panel">

  <h2><?php esc_html_e('Ajaxified FAQ Search Settings', 'afs-addon'); ?></h2>

  <?php if (isset($_GET['settings-updated'])) { ?>
  <div id="message" class="updated">
    <p><strong><?php esc_html_e('Settings saved.', 'afs-addon') ?></strong></p>
  </div>
  <?php } ?>

  <form action="options.php" method="post">
    <?php settings_fields('afs_options') ?>
    <?php do_settings_sections(__FILE__); ?>

    <p class="submit">
      <input name="submit" type="submit" class="button-primary"
        value="<?php esc_html_e('Save Settings', 'afs-addon'); ?>" />
    </p>
  </form>

</div>

<?php

}


function afs_register_settings_fields()
{

    // First Parameter option group.
    // Second Parameter contain keyword. use in get_options() function.

    register_setting('afs_options', 'afs_options');

    // Common Settings.        
    add_settings_section('afs_display_section', esc_html__("Display Settings: ", 'afs-addon'), "afs_display_section_cb", __FILE__);
    add_settings_field('afs_sticky_status',  esc_html__("Display Sticky Button? ", 'afs-addon'), "afs_sticky_btn_settings", __FILE__, 'afs_display_section');
    add_settings_field('afs_sticky_search_result_type',  esc_html__("Sticky Search Output Type: ", 'afs-addon'), "afs_sticky_search_output_type_settings", __FILE__, 'afs_display_section');
    add_settings_field('afs_placeholder_text',  esc_html__("Search Placeholder Text: ", 'afs-addon'), "afs_placeholder_text_settings", __FILE__, 'afs_display_section');

    add_settings_field('afs_sticky_container_bg',  esc_html__("Sticky Container Background: ", 'afs-addon'), "afs_sticky_container_bg_settings", __FILE__, 'afs_display_section');
    add_settings_field('afs_search_window_color',  esc_html__("Search Window Background: ", 'afs-addon'), "afs_search_window_color_setting", __FILE__, 'afs_display_section');
    add_settings_field('afs_window_in_animation',  esc_html__("Window In Animation: ", 'afs-addon'), "afs_search_window_in_settings", __FILE__, 'afs_display_section');
    add_settings_field('afs_window_out_animation',  esc_html__("Window Out Animation: ", 'afs-addon'), "afs_search_window_out_settings", __FILE__, 'afs_display_section');
    add_settings_field('afs_faq_per_page',  esc_html__("FAQ Pagination(Item Per Page): ", 'afs-addon'), "afs_pagination_settings", __FILE__, 'afs_display_section');

    add_settings_field('afs_sugg_box_container_bg',  esc_html__("Suggestion Box Background: ", 'afs-addon'), "afs_sugg_box_container_bg_settings", __FILE__, 'afs_display_section');
    add_settings_field('afs_sugg_box_text_color',  esc_html__("Suggestion Text Color: ", 'afs-addon'), "afs_sugg_box_text_color_setting", __FILE__, 'afs_display_section');
    add_settings_field('afs_sugg_box_text_hover_color',  esc_html__("Suggestion Text Hover Color: ", 'afs-addon'), "afs_sugg_box_text_hover_color_setting", __FILE__, 'afs_display_section');
}

/**
 * @Description: Search Placeholder Text
 * @Created At: 25-08-2018
 * @Last Edited AT: 25-08-2018
 * @Created By: Mahbub
 **/

function afs_placeholder_text_settings()
{

    $afs_options = get_option('afs_options');

    $afs_placeholder_text  =  esc_html__('Search Keywords (how to, what is )..... ', 'afs-addon');

    if (isset($afs_options['afs_placeholder_text'])) {

        $afs_placeholder_text = $afs_options['afs_placeholder_text'];
    }

    echo '<input type="text" name="afs_options[afs_placeholder_text]" id="afs_placeholder_text" size="50" value="' . sanitize_text_field($afs_placeholder_text) . '" />';
}


/**
 * @Description: Sticky Container Background Color Settings.
 * @Created At: 04-07-2015
 * @Last Edited AT: 04-07-2015
 * @Created By: Mahbub
 **/

function afs_sticky_container_bg_settings()
{

    $afs_options = get_option('afs_options');

    $afs_sticky_container_bg  = "#2c2c2c";

    if (isset($afs_options['afs_sticky_container_bg'])) {

        $afs_sticky_container_bg = strtoupper($afs_options['afs_sticky_container_bg']);
    }

    echo '<input type="text" name="afs_options[afs_sticky_container_bg]" id="afs_sticky_container_bg" class="medium-text ltr" value="' . $afs_sticky_container_bg . '" />';
}


/**
 * @Description: Search Window Color Settings.
 * @Created At: 04-07-2015
 * @Last Edited AT: 04-07-2015
 * @Created By: Mahbub
 **/

function afs_search_window_color_setting()
{

    $afs_options = get_option('afs_options');

    $afs_search_window_color  = "#3498DB";

    if (isset($afs_options['afs_search_window_color'])) {

        $afs_search_window_color = strtoupper($afs_options['afs_search_window_color']);
    }

    echo '<input type="text" name="afs_options[afs_search_window_color]" id="afs_search_window_color" class="medium-text ltr" value="' . $afs_search_window_color . '" />';
}

/**
 * @Description: Sticky Container Button Settings.
 * @Created At: 04-07-2015
 * @Last Edited AT: 04-07-2015
 * @Created By: Mahbub
 **/

function afs_sticky_search_output_type_settings()
{

    $afs_options = get_option('afs_options');

    $afs_sticky_search_result_type  = 1;

    if (isset($afs_options['afs_sticky_search_result_type'])) {

        $afs_sticky_search_result_type = $afs_options['afs_sticky_search_result_type'];
    }


    if ($afs_sticky_search_result_type == 1) {

        $accordion_status = "";
        $sugg_box_status = "selected=selected";
    } else {

        $accordion_status = "selected=selected";
        $sugg_box_status = "";
    }

    echo '<select name="afs_options[afs_sticky_search_result_type]">
                    <option value="0" ' . $accordion_status . '>' . esc_html__('Accordion (Default)', 'afs-addon') . '</option>   
                    <option value="1" ' . $sugg_box_status . '>' . esc_html__('Suggestion Box', 'afs-addon') . '</option>               
                 </select>';
}


/**
 * @Description: Sticky Container Button Settings.
 * @Created At: 04-07-2015
 * @Last Edited AT: 04-07-2015
 * @Created By: Mahbub
 **/

function afs_sticky_btn_settings()
{

    $afs_options = get_option('afs_options');

    $afs_sticky_status  = 1;

    if (isset($afs_options['afs_sticky_status'])) {

        $afs_sticky_status = $afs_options['afs_sticky_status'];
    }


    if ($afs_sticky_status == 1) {

        $show_status = "selected=selected";
        $hide_status = "";
    } else {

        $show_status = "";
        $hide_status = "selected=selected";
    }

    echo '<select name="afs_options[afs_sticky_status]">
                    <option value="1" ' . $show_status . '>' . esc_html__('Show', 'afs-addon') . '</option>   
                    <option value="0" ' . $hide_status . '>' . esc_html__('Hide', 'afs-addon') . '</option>               
                 </select>';
}


/**
 * @Description: Pagination Settings.
 * @Created At: 04-07-2015
 * @Last Edited AT: 04-07-2015
 * @Created By: Mahbub
 **/

function afs_pagination_settings()
{

    $afs_options = get_option('afs_options');

    $afs_faq_per_page  = "";

    if (isset($afs_options['afs_faq_per_page'])) {

        $afs_faq_per_page = $afs_options['afs_faq_per_page'];
    }


    $afs_faq_per_page_string =  '<select name="afs_options[afs_faq_per_page]">';

    $afs_faq_per_page_string .= '<option value="" "selected=selected"> ' . esc_html__('Select', 'afs-addon') . ' </option>';

    for ($i = 1; $i <= 30; $i++) {

        if ($afs_faq_per_page == $i) {

            $selected_status = "selected=selected";
        } else {

            $selected_status = "";
        }


        $afs_faq_per_page_string .= '<option value="' . $i . '" ' . $selected_status . '>' . $i . '</option>';
    }

    $afs_faq_per_page_string .= "</select>";

    echo $afs_faq_per_page_string;
}

/**
 * @Description: Window In Animation Settings.
 * @Created At: 04-07-2015
 * @Last Edited AT: 04-07-2015
 * @Created By: Mahbub
 **/

function afs_search_window_in_settings()
{

    $afs_options = get_option('afs_options');

    $afs_window_in_animation  = "";

    if (isset($afs_options['afs_window_in_animation'])) {

        $afs_window_in_animation = $afs_options['afs_window_in_animation'];
    }


    $afs_animation_string =  '<select name="afs_options[afs_window_in_animation]">';

    $afs_animation_string .= '<option value="" "selected=selected"> ' . esc_html__('Select', 'afs-addon') . ' </option>';

    $afs_in_animation = [
        'bounce' => 'bounce',
        'bounceIn' => 'bounce In',
        'bounceInDown' => 'bounce In Down',
        'bounceInLeft' => 'bounce In Left',
        'bounceInRight' => 'bounce In Right',
        'bounceInUp' => 'bounce In Up',
        'fadeIn' => 'fadeIn',
        'fadeInDown' => 'fade In Down',
        'fadeInDownBig' => 'fade In Down Big',
        'fadeInLeft' => 'fade In Left',
        'fadeInLeftBig' => 'fade In LeftBig',
        'fadeInRight' => 'fade In Right',
        'fadeInRightBig' => 'fade In Right Big',
        'fadeInUp' => 'fade In Up',
        'fadeInUpBig' => 'fade In UpBig',
        'flip' => 'flip',
        'flipInX' => 'flip In X',
        'flipInY' => 'flip In Y',
        'lightSpeedIn' => 'light Speed In',
        'rotateIn' => 'rotate In',
        'rotateInDownLeft' => 'rotate In Down Left',
        'rotateInDownRight' => 'rotate In Down Right',
        'rotateInUpLeft' => 'rotate In Up Left',
        'rotateInUpRight' => 'rotate In Up Right',
        'slideInUp' => 'slide In Up',
        'slideInDown' => 'slide In Down',
        'slideInLeft' => 'slide In Left',
        'slideInRight' => 'slide In Right',
        'zoomIn' => 'zoom In',
        'zoomInDown' => 'zoom In Down',
        'zoomInLeft' => 'zoom In Left',
        'zoomInRight' => 'zoom In Right',
        'zoomInUp' => 'zoom In Up',
        'hinge' => 'hinge',
        'rollIn' => 'roll In'
    ];


    foreach ($afs_in_animation as $afs_animation_key => $afs_animation_value) :

        if ($afs_window_in_animation == $afs_animation_key) {

            $selected_status = "selected=selected";
        } else {

            $selected_status = "";
        }

        $afs_animation_string .= '<option value="' . $afs_animation_key . '" ' . $selected_status . '>' .  ucfirst($afs_animation_value) . '</option>';

    endforeach;

    $afs_animation_string .= "</select>";

    echo $afs_animation_string;
}

/**
 * @Description: Window Out Animation Settings.
 * @Created At: 04-07-2015
 * @Last Edited AT: 04-07-2015
 * @Created By: Mahbub
 **/

function afs_search_window_out_settings()
{

    $afs_options = get_option('afs_options');

    $afs_window_out_animation  = "";

    if (isset($afs_options['afs_window_out_animation'])) {

        $afs_window_out_animation = $afs_options['afs_window_out_animation'];
    }


    $afs_animation_string =  '<select name="afs_options[afs_window_out_animation]">';

    $afs_animation_string .= '<option value="" "selected=selected"> ' . esc_html__('Select', 'afs-addon') . ' </option>';

    $afs_out_animation = [
        'bounce' => 'bounce',
        'bounceOut' => 'bounce Out',
        'bounceOutDown' => 'bounce Out Down',
        'bounceOutLeft' => 'bounce Out Left',
        'bounceOutRight' => 'bounce Out Right',
        'bounceOutUp' => 'bounce Out Up',
        'fadeOut' => 'fade Out',
        'fadeOutDown' => 'fade Out Down',
        'fadeOutDownBig' => 'fade Out Down Big',
        'fadeOutLeft' => 'fade Out Left',
        'fadeOutLeftBig' => 'fade Out Left Big',
        'fadeOutRight' => 'fade Out Right',
        'fadeOutRightBig' => 'fade Out Right Big',
        'fadeOutUp' => 'fade Out Up',
        'fadeOutUpBig' => 'fade Out Up Big',
        'flip' => 'flip',
        'flipOutX' => 'flip Out X',
        'flipOutY' => 'flip Out Y',
        'lightSpeedOut' => 'light Speed Out',
        'rotateOut' => 'rotate Out',
        'rotateOutDownLeft' => 'rotate Out Down Left',
        'rotateOutDownRight' => 'rotate Out Down Right',
        'rotateOutUpLeft' => 'rotate Out Up Left',
        'rotateOutUpRight' => 'rotate Out Up Right',
        'slideOutUp' => 'slide Out Up',
        'slideOutDown' => 'slide Out Down',
        'slideOutLeft' => 'slide Out Left',
        'slideOutRight' => 'slide Out Right',
        'zoomOut' => 'zoom Out',
        'zoomOutDown' => 'zoom Out Down',
        'zoomOutLeft' => 'zoom Out Left',
        'zoomOutRight' => 'zoom Out Right',
        'zoomOutUp' => 'zoom Out Up',
        'hinge' => 'hinge',
        'rollOut' => 'rollOut'
    ];


    foreach ($afs_out_animation as $afs_animation_key => $afs_animation_value) :

        if ($afs_window_out_animation == $afs_animation_key) {

            $selected_status = "selected=selected";
        } else {

            $selected_status = "";
        }

        $afs_animation_string .= '<option value="' . $afs_animation_key . '" ' . $selected_status . '>' . ucfirst($afs_animation_value) . '</option>';

    endforeach;

    $afs_animation_string .= "</select>";

    echo $afs_animation_string;
}



/**
 * @Description: Suggestion Box Container Background Color Settings.
 * @Created At: 04-07-2015
 * @Last Edited AT: 04-07-2015
 * @Created By: Mahbub
 **/

function afs_sugg_box_container_bg_settings()
{

    $afs_options = get_option('afs_options');

    $afs_sugg_box_container_bg  = "#2c2c2c";

    if (isset($afs_options['afs_sugg_box_container_bg'])) {

        $afs_sugg_box_container_bg = strtoupper($afs_options['afs_sugg_box_container_bg']);
    }

    echo '<input type="text" name="afs_options[afs_sugg_box_container_bg]" id="afs_sugg_box_container_bg" class="medium-text ltr" value="' . sanitize_hex_color($afs_sugg_box_container_bg) . '" />';
}


/**
 * @Description: Suggestion Box Text Color Settings.
 * @Created At: 04-07-2015
 * @Last Edited AT: 04-07-2015
 * @Created By: Mahbub
 **/

function afs_sugg_box_text_color_setting()
{

    $afs_options = get_option('afs_options');

    $afs_sugg_box_text_color  = "#FFFFFF";

    if (isset($afs_options['afs_sugg_box_text_color'])) {

        $afs_sugg_box_text_color = strtoupper($afs_options['afs_sugg_box_text_color']);
    }

    echo '<input type="text" name="afs_options[afs_sugg_box_text_color]" id="afs_sugg_box_text_color" class="medium-text ltr" value="' . sanitize_hex_color($afs_sugg_box_text_color) . '" />';
}


/**
 * @Description: Suggestion Box Text Hover Color Settings.
 * @Created At: 04-07-2015
 * @Last Edited AT: 04-07-2015
 * @Created By: Mahbub
 **/

function afs_sugg_box_text_hover_color_setting()
{

    $afs_options = get_option('afs_options');

    $afs_sugg_box_text_hover_color  = "#F3F3F3";

    if (isset($afs_options['afs_sugg_box_text_hover_color'])) {

        $afs_sugg_box_text_hover_color = strtoupper($afs_options['afs_sugg_box_text_hover_color']);
    }

    echo '<input type="text" name="afs_options[afs_sugg_box_text_hover_color]" id="afs_sugg_box_text_hover_color" class="medium-text ltr" value="' . sanitize_hex_color($afs_sugg_box_text_hover_color) . '" />';
}



function afs_custom_theme_cb()
{
    // Add option Later.        
}

/*------------------------------ Form Input ---------------------------------*/

function afs_display_section_cb()
{
    // Add option Later.    
}

/**
 * Add the settings page to the admin menu
 */

function afs_settings_submenu()
{

    add_submenu_page(
        'edit.php?post_type=bwl_advanced_faq',
        esc_html__('Ajaxified FAQ Search Settings.', 'afs-addon'),
        esc_html__('Ajaxified Search', 'afs-addon'),
        'administrator',
        'afs-settings',
        'afs_settings'
    );
}

add_action('admin_menu', 'afs_settings_submenu');

add_action('admin_init', 'afs_register_settings_fields');