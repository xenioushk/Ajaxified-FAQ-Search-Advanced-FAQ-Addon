;(function ($) {
  $(function () {
    var afs_search_window_color = $("input#afs_search_window_color"),
      afs_sticky_container_bg = $("input#afs_sticky_container_bg"),
      afs_sugg_box_container_bg = $("input#afs_sugg_box_container_bg"),
      afs_sugg_box_text_color = $("input#afs_sugg_box_text_color"),
      afs_sugg_box_text_hover_color = $("input#afs_sugg_box_text_hover_color")

    afs_search_window_color.wpColorPicker()
    afs_sticky_container_bg.wpColorPicker()
    afs_sugg_box_container_bg.wpColorPicker()
    afs_sugg_box_text_color.wpColorPicker()
    afs_sugg_box_text_hover_color.wpColorPicker()
  })
})(jQuery)
