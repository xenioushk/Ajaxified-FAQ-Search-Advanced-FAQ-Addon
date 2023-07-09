<?php

/*-- AJAX Settings--*/

if (!function_exists('afs_set_custom_js_param')) {

    function afs_set_custom_js_param()
    {

        $afs_data = get_option('afs_options');

        $afs_search_window_color =  '#3498DB';
        $afs_window_in_animation =  'zoomIn';
        $afs_window_out_animation =  'bounceOutDown';

        if (isset($afs_data['afs_search_window_color']) && $afs_data['afs_search_window_color'] != "") {

            $afs_search_window_color =  $afs_data['afs_search_window_color'];
        }

        if (isset($afs_data['afs_window_in_animation']) && $afs_data['afs_window_in_animation'] != "") {

            $afs_window_in_animation =  $afs_data['afs_window_in_animation'];
        }

        if (isset($afs_data['afs_window_out_animation']) && $afs_data['afs_window_out_animation'] != "") {

            $afs_window_out_animation =  $afs_data['afs_window_out_animation'];
        }


?>


<script type="text/javascript">
var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>',
  afs_search_window_color = '<?php echo $afs_search_window_color; ?>',
  afs_window_in_animation = '<?php echo $afs_window_in_animation; ?>',
  afs_window_out_animation = '<?php echo $afs_window_out_animation; ?>',
  afs_search_no_results_msg = '<?php esc_html_e('Sorry Nothing Found!', 'afs-addon'); ?>';
</script>

<?php

    }

    add_action('wp_head', 'afs_set_custom_js_param');
} else {

    echo "afs_set_ajax_url - Function already exist!";
}

function afs_get_sticky_items()
{

    $afs_data = get_option('afs_options');

    $afs_sticky_status  = 1;
    $afs_sticky_search_result_type = 0; //0=Accordion & 1=Suggestion Box.
    $afs_placeholder_text = esc_html__('Search Keywords (how to, what is )..... ', 'afs-addon');

    $afs_sticky_html = "";

    if (isset($afs_data['afs_sticky_status']) && $afs_data['afs_sticky_status'] == 0) {
        $afs_sticky_status = 0;
    }

    if (isset($afs_data['afs_sticky_search_result_type']) && $afs_data['afs_sticky_search_result_type'] == 1) {
        $afs_sticky_search_result_type = 1;
    }

    if (isset($afs_data['afs_placeholder_text']) && $afs_data['afs_placeholder_text'] != "") {
        $afs_placeholder_text = $afs_data['afs_placeholder_text'];
    }


    if ($afs_sticky_status == 1) {

        wp_enqueue_script('afs-custom-script'); // Fixed in version 1.0.1

        $afs_search_html = "";
        $afs_search_modal_window = "";

        $afs_search_html .= '<li id="afs_search_popup"  class="afs_search_popup">
                                           <a href="#asf_animated_modal" id="asf_modal_trigger" title="' . esc_html__('Search FAQ', 'afs-addon') . '"><i class="fa fa-question-circle"></i>  <span>' . esc_html__('Search FAQ', 'afs-addon') . '</span></a>
                                          </li>';

        $afs_search_modal_window .= '<div id="asf_animated_modal">
                                                            <div  id="btn-close-modal" class="close-asf_animated_modal"> 
                                                                X
                                                            </div>

                                                            <div class="modal-content">'
            .  do_shortcode("[afs_search sugg_box='" . $afs_sticky_search_result_type . "' placeholder='" . $afs_placeholder_text . "'/]") .
            '</div>
                                                        </div>';

        $afs_search_modal_window .= '<div id="popup1" style="display:none;">
                <h2>Test Form</h2>
            </div>';


        $afs_sticky_html .= '<div class="afs-sticky-container">
                                            <ul class="afs-sticky">
                                            ' . $afs_search_html . '
                                            </ul>
                                      </div>';



        $afs_sticky_html = $afs_sticky_html . $afs_search_modal_window;
    }

    echo $afs_sticky_html;
}


add_action('wp_footer', 'afs_get_sticky_items', 1);


/*--Clean Up Shortcode--*/


function afs_clean_shortcodes($content)
{
    $array = [
        '<p>[' => '[',
        ']</p>' => ']',
        ']<br />' => ']'
    ];
    $content = strtr($content, $array);
    return $content;
}
add_filter('the_content', 'afs_clean_shortcodes');