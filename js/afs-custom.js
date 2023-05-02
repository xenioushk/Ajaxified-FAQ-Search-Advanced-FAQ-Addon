;(function ($) {
  $(document).ready(function () {
    /*---Sticky Tab Options ---*/

    var afs_sticky_container = $(".afs-sticky-container")

    if (afs_sticky_container.length > 0) {
      /*--- Front End Admin Menu ---*/

      function asf_manage_wp_admin_header() {
        if ($("#wpadminbar").length > 0) {
          $("#asf_animated_modal").css({
            "padding-top": $("#wpadminbar").outerHeight(),
          })
        }
      }

      var afs_handle_sticky_container_height = function () {
        var afs_height = $(window).height()

        if (afs_height / 2 < 100) {
          afs_sticky_container.css({
            opacity: 0,
          })
        } else {
          afs_sticky_container.css({
            top: afs_height / 2 - 50,
            opacity: 1,
          })
        }
      }

      afs_handle_sticky_container_height()
      asf_manage_wp_admin_header()

      // If we resize window then following function will call again.

      $(window).resize(function () {
        afs_handle_sticky_container_height()
        asf_manage_wp_admin_header()
      })

      /*----Modal Action ---*/

      $("#asf_modal_trigger").animatedModal({
        modalTarget: "asf_animated_modal",
        animatedIn: afs_window_in_animation,
        animatedOut: afs_window_out_animation,
        color: afs_search_window_color,
        // Callbacks
        beforeOpen: function () {
          //            console.log("The animation was called");
        },
        afterOpen: function () {
          //            console.log("The animation is completed");
        },
        beforeClose: function () {
          //            console.log("The animation was called");
        },
        afterClose: function () {
          //            console.log("The animation is completed");
        },
      })
    }
  })
})(jQuery)
