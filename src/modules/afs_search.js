;(function ($) {
  $(function () {
    var afs_filter_container = $(".afs_filter_container")
    if (typeof afs_filter_container != "undefined") {
      var baf_display_limit = 10

      afs_filter_container.each(function () {
        var live_search_field = $(this).find(".s"),
          afs_clear_btn = $(this).find(".afs-btn-clear")

        live_search_field.val("").addClass("afs_search_icon")

        var filter_timeout

        live_search_field.on("keyup", function () {
          live_search_field = $(this)

          var afs_search_box_unique_id = live_search_field.data("search-box-unique-id"),
            afs_suggestion_box = live_search_field.data("sugg_box"),
            afs_search_results = afs_filter_container.find("#output_suggestions_" + afs_search_box_unique_id)

          // Output For JSON Data.

          var suggestions = afs_filter_container.find("#suggestions_" + afs_search_box_unique_id),
            suggestionsList = afs_filter_container.find("#suggestionsList_" + afs_search_box_unique_id)

          live_search_field.addClass("afs_loading")
          afs_clear_btn.addClass("afs-dn")

          clearTimeout(filter_timeout)

          var search_keywords = $.trim(live_search_field.val())

          if (search_keywords.length < 2) {
            suggestions.fadeOut()
            afs_search_results.html("").hide()
            live_search_field.removeClass("afs_loading")
            afs_clear_btn.addClass("afs-dn")
          }

          filter_timeout =
            search_keywords.length >= 2 &&
            setTimeout(function () {
              $.when(handle_server_search_response(search_keywords, afs_search_box_unique_id, afs_suggestion_box)).done(function (data) {
                afs_clear_btn.removeClass("afs-dn")

                if (typeof afs_suggestion_box != "undefined" && afs_suggestion_box == 1) {
                  //                        console.log(" "+data.toSource());
                  active_suggestion_box(suggestions, afs_clear_btn, data, suggestionsList, live_search_field)
                } else {
                  afs_search_results
                    .html("")
                    .html(data)
                    .show(0, function () {
                      active_accordion()
                    })

                  live_search_field.removeClass("afs_loading")
                }
              })
            }, 900)
        })

        live_search_field.keypress(function (e) {
          if (e.keyCode === 13) {
            return false
          }
        })

        // Clear Button Click Event.

        afs_clear_btn.on("click", function () {
          var output_suggestions = afs_filter_container.find("#output_suggestions_" + jQuery(this).data("unique_id"))

          afs_clear_btn.addClass("afs-dn")
          output_suggestions.html("").hide()
          live_search_field.val("").addClass("afs_search_icon")
          afs_filter_container.find(".suggestionsBox").fadeOut()
        })
      })

      function active_suggestion_box(suggestions, afs_clear_btn, data, suggestionsList, live_search_field) {
        //        console.log("Data: "+data.toSource());
        //console.log(isNaN(data));
        suggestions.fadeIn()
        afs_clear_btn.removeClass("afs-dn")
        var search_result_html = "<ul>"

        if (isNaN(data) && data.length > 0) {
          jQuery.each(data, function (index, result) {
            search_result_html += '<li><a href="' + result.link + '">' + result.title + "</a></li>"
          })
        } else {
          search_result_html += '<li class="nothing-found">' + afs_search_no_results_msg + "</li>"
        }

        search_result_html += "</ul>"

        suggestionsList.html(search_result_html)
        live_search_field.removeClass("afs_loading")
      }

      function handle_server_search_response(search_keywords, search_box_unique_id, afs_suggestion_box) {
        var data_type = "HTML"

        if (typeof afs_suggestion_box != "undefined" && afs_suggestion_box == 1) {
          data_type = "JSON"
        }

        return $.ajax({
          url: ajaxurl,
          type: "POST",
          dataType: data_type,
          data: {
            action: "afs_get_search_results", // action will be the function name
            afs_ajax_search: true,
            s: search_keywords,
            search_box_unique_id: search_box_unique_id,
            output_format: data_type,
          },
        })
      }

      function active_accordion() {
        $("section.ac-container").each(function () {
          // Write all code inside of this block.

          var $baf_section = $(this)
          baf_trigger_accordion_click_event($baf_section)
          //            console.log("Length"+$baf_section.attr('container_id'));
          var $baf_item_per_page_val = $baf_section.find(".baf_page_navigation").data("pag_limit")
          var $baf_paginate_status = $baf_section.find(".baf_page_navigation").data("paginate")
          //
          if ($baf_paginate_status == 0) {
            $baf_item_per_page_val = $baf_section.find(".bwl-faq-container").size() // get all FAQ size
          }
          //
          //                    // Initially We display 5 items and hide other items.
          //
          baf_get_pagination_html($baf_section, $baf_item_per_page_val)
          //
          var $baf_container_id = $baf_section.attr("container_id")
          var $baf_expand_btn = $baf_section.find(".baf-expand-all"),
            $baf_collapsible_btn = $baf_section.find(".baf-collapsible-all")
          //
          if ($baf_expand_btn.length == 1 && $baf_collapsible_btn.length == 1) {
            var label_default_state_color = $baf_section.find("label").attr("style")

            $baf_expand_btn.on("click", function () {
              $("div.bwl-faq-container-" + $baf_container_id).each(function () {
                // Display Articles.
                $(this).find("article").removeAttr("style").removeClass("baf-hide-article").addClass("baf-show-article baf-article-padding")
                // Update Label Icon.
                $(this).find("label").removeAttr("class").addClass("opened-label")
                // Update Check Box Status.
                $(this).find("input[type=checkbox]").prop("checked", false) // Unchecks it
              })
            })

            $baf_collapsible_btn.on("click", function () {
              $("div.bwl-faq-container-" + $baf_container_id).each(function () {
                // Display Articles.
                $(this).find("article").removeAttr("style").removeClass("baf-show-article baf-article-padding").addClass("baf-hide-article article-box-shadow")
                // Update Label Icon.
                $(this).find("label").removeAttr("class").addClass("closed-label")
                // Update Check Box Status.
                $(this).find("input[type=checkbox]").prop("checked", true) // Unchecks it
              })
            })
          }
        })
      }

      function baf_get_pagination_html($baf_section, show_per_page, number_of_items, baf_search) {
        // show_per_page == start_on
        // number_of_items = end_on

        var $baf_paginate_status = $baf_section.find(".baf_page_navigation").data("paginate")

        if ($baf_paginate_status == 0) {
          var $baf_search_field = $baf_section.find("#bwl_filter_" + $baf_section.attr("container_id"))
          var $baf_search_field_current_value = $.trim($baf_search_field.val())

          if ($baf_search_field_current_value.length > -1 && $baf_search_field_current_value.length < 2) {
            $baf_section.find("div.bwl-faq-container").css("display", "block")
          }

          $baf_search_field.removeClass("search_load").addClass("search_icon")
          return false
        }

        if (typeof baf_search != "undefined" && baf_search == 1) {
          if ($baf_paginate_status == 1) {
            var $searched_faq_items = $baf_section.find("div.bwl-faq-container:visible")

            $searched_faq_items.addClass("filter")

            var total_faq_items = $searched_faq_items.size()
            var number_of_items = number_of_items
            var $items_need_to_show = $searched_faq_items.slice(0, show_per_page)
            var $items_need_to_hide = $searched_faq_items.slice(show_per_page, total_faq_items)
            $items_need_to_hide.css("display", "none")
          }

          $baf_section.find("input[type=text]").removeClass("search_load").addClass("search_icon")
        } else {
          //getting the amount of elements inside content div

          $baf_section.find("div.bwl-faq-container").css("display", "none")

          //and show the first n (show_per_page) elements
          $baf_section.find("div.bwl-faq-container").slice(0, show_per_page).css("display", "block")

          var number_of_items = $baf_section.find("div.bwl-faq-container").size()
        }

        //calculate the number of pages we are going to have
        var number_of_pages = Math.ceil(number_of_items / show_per_page)

        //set the value of our hidden input fields
        $baf_section.find("#current_page").val(0)
        $baf_section.find("#show_per_page").val(show_per_page)
        //now when we got all we need for the navigation let's make it '

        /*
                 what are we going to have in the navigation?
                 - link to previous page
                 - links to specific pages
                 - link to next page
                 */
        var navigation_html = '<div class="baf_page_num"><a class="previous_link" href="#"><i class="fa fa-chevron-left"></i></a>'
        var current_link = 0

        var page_array = []
        var display_none_class = ""
        var baf_pages_string = string_singular_page
        while (number_of_pages > current_link) {
          page_array[current_link] = current_link

          if (number_of_pages > baf_display_limit && current_link >= baf_display_limit) {
            display_none_class = " baf_dn"
          }

          navigation_html += '<a class="page_link' + display_none_class + '" href="#" longdesc="' + current_link + '">' + (current_link + 1) + "</a>"
          current_link++
        }

        if (number_of_pages > 1) {
          baf_pages_string = string_plural_page
        }

        navigation_html += '<a class="next_link" href="#"><i class="fa fa-chevron-right"></i></a></div><div class="total_pages">' + string_total + " " + number_of_pages + " " + baf_pages_string + "</div>"

        $baf_section.find("#baf_page_navigation").html("").html(navigation_html)

        if ($baf_paginate_status == 0) {
          $baf_section.find("#baf_page_navigation").remove()
        }

        if (page_array.length == 0) {
          $baf_section.find("#baf_page_navigation").css("display", "none")
        } else {
          $baf_section.find("#baf_page_navigation").css("display", "block")
        }

        //add active_page class to the first page link
        $baf_section.find("#baf_page_navigation .page_link:first").addClass("active_page")

        $baf_section.find(".next_link").on("click", function () {
          var new_page = parseInt($baf_section.find("#current_page").val()) + 1

          //if there is an item after the current active link run the function

          var $active_page = $baf_section.find(".active_page").next(".page_link")

          if ($active_page.length == true) {
            if ($active_page.hasClass("baf_dn")) {
              $active_page.removeClass("baf_dn")

              var total_link_need_to_hide = parseInt($baf_section.find("a.page_link:visible").length) - baf_display_limit

              $baf_section.find("a.page_link:visible").slice(0, total_link_need_to_hide).addClass("baf_dn")
            }

            baf_go_to_page($baf_section, new_page)
          }
          return false
        })

        $baf_section.find(".previous_link").on("click", function () {
          var new_page = parseInt($baf_section.find("#current_page").val()) - 1
          //if there is an item before the current active link run the function

          var $active_page = $baf_section.find(".active_page").prev(".page_link")
          var number_of_items = $baf_section.find("div.bwl-faq-container").size()
          var start = parseInt($baf_section.find("a.page_link:visible:first").attr("longdesc")) - 1

          var end = $baf_section.find("a.page_link:visible:last").attr("longdesc")

          if ($active_page.length == true) {
            if (start > -1 && end < number_of_items) {
              $baf_section.find("a.page_link").addClass("baf_dn")
              $baf_section.find("a.page_link").slice(start, end).removeClass("baf_dn")
            }

            baf_go_to_page($baf_section, new_page)
          }
          return false
        })

        $baf_section.find(".page_link").on("click", function () {
          var current_link = $(this).attr("longdesc")

          baf_go_to_page($baf_section, current_link)
          return false
        })
      }

      function baf_go_to_page($baf_section, page_num) {
        var search_status = 0

        if ($baf_section.find("input[type=text]").length && $baf_section.find("input[type=text]").val().length > 1) {
          search_status = 1
        }

        var show_per_page = parseInt($baf_section.find("#show_per_page").val())

        //get the element number where to start the slice from
        var start_from = page_num * show_per_page

        //get the element number where to end the slice
        var end_on = start_from + show_per_page

        if (search_status == 1) {
          $baf_section.find("div.filter").css("display", "none").slice(start_from, end_on).css("display", "block")
        } else {
          $baf_section.find("div.bwl-faq-container").css("display", "none").slice(start_from, end_on).css("display", "block")
        }

        /*get the page link that has longdesc attribute of the current page and add active_page class to it
                 and remove that class from previously active page link*/
        $baf_section
          .find(".page_link[longdesc=" + page_num + "]")
          .addClass("active_page")
          .siblings(".active_page")
          .removeClass("active_page")

        //update the current page input field
        $baf_section.find("#current_page").val(page_num)
      }

      function baf_trigger_accordion_click_event(accordion_container) {
        // Regular Collapsable Accordion

        //New Code.
        accordion_container.find("article").removeAttr("style").addClass("baf-hide-article article-box-shadow")

        // Now we set all checkbox checked.

        accordion_container.find("input[type=checkbox]").prop("checked", true)

        accordion_container.find("label").addClass("closed-label")

        accordion_container.find("label").on("click", function () {
          var label_id = $(this).attr("label_id"),
            parent_container_id = $(this).attr("parent_container_id")

          // Modify Accordion Container.

          accordion_container = $(".ac-container[container_id=" + parent_container_id + "]")

          /*------------------------------  LABEL SECTION ---------------------------------*/

          var current_faq_label_container = $(this),
            current_faq_checkbox = current_faq_label_container.next("input[type=checkbox]"), // here we need to keep squence. First Label, then checkbox , then article. It's releated with shortcode output.
            current_article_faq_container = current_faq_checkbox.next("article")

          /*------------------------------  ARTICLE SECTION---------------------------------*/

          if (current_faq_checkbox.is(":checked")) {
            //New Code.
            accordion_container.find("article").removeAttr("style").removeClass("baf-show-article baf-article-padding").addClass("baf-hide-article article-box-shadow")

            // Now we set all checkbox checked.

            accordion_container.find("input[type=checkbox]").prop("checked", true) //
            accordion_container.find("label").removeAttr("class").addClass("closed-label")

            // Checked
            current_faq_checkbox.prop("checked", true) // Uncheck it
            current_article_faq_container.removeAttr("style").removeClass("baf-hide-article").addClass("baf-show-article baf-article-padding")
            current_faq_label_container.removeAttr("class").addClass("opened-label")
          } else {
            // For Unchecked.

            accordion_container.find("article").removeAttr("style").removeClass("baf-show-article baf-article-padding").addClass("baf-hide-article article-box-shadow")
            accordion_container.find("label").removeAttr("class").addClass("closed-label")
          }
        })
      }
    }
  })
})(jQuery)
