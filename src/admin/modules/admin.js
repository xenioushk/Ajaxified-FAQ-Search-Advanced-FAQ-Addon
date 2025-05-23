;(function ($) {
  $(function () {
    // Initialize the color picker for the specified fields
    const colorPickerFields = ["#afs_search_window_color", "#afs_sticky_container_bg", "#afs_sugg_box_container_bg", "#afs_sugg_box_text_color", "#afs_sugg_box_text_hover_color"]

    colorPickerFields.forEach((selector) => {
      // Initialize the color picker for each field
      if ($(selector).length) {
        $(selector).wpColorPicker()
      }
    })
  })
})(jQuery)
