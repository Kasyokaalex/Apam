function enable_delete(confirm_message, none_selected_message) {
  //Keep track of enable_delete has been called
  if (!enable_delete.enabled) enable_delete.enabled = true;

  $(document).on("click", "#delete", function (event) {
    event.preventDefault();

    var $this = $(this);

    var selected = $this.attr("data-id");

    if (new Number(selected) > 0) {
      alertify
        .confirm(
          "Deleting a record !!",
          "<span style='font-size:30px;position:absolute;top:58px' class='fi fi-sr-delete text-danger'></span> <span style='margin-left:55px'>" +
            confirm_message +
            "</span>",
          onOk,
          null
        )
        .set("labels", { ok: "Yes", cancel: "cancel" });

      function onOk() {
        do_delete($this.attr("href"), selected);
      }
    } else {
      alertify.alert(none_selected_message);
    }
  });
}

function enable_delete_with_authentication(
  confirm_message,
  none_selected_message,
  staffID
) {
  //Keep track of enable_delete has been called
  if (!enable_delete_with_authentication.enabled)
    enable_delete_with_authentication.enabled = true;

  $(document).on("click", "#delete", function (event) {
    event.preventDefault();

    $("#username").val(""); // Clear username

    $("#password").val(""); // Clear Password

    var $this = $(this);

    var selected = $this.attr("data-id");

    if (new Number(selected) > 0) {
      alertify
        .confirm("Authentication required !!", confirm_message, onOk, null)
        .set("labels", { ok: "confirm delete", cancel: "cancel" });

      function onOk() {
        // confirm that user is authorized to delete

        var username = $("#username").val();

        var password = $("#password").val();

        if (username == "" || password == "") {
          set_feedback("error", "Invalid Credentials, Please Try Again", false);
        } else {
          $.get(
            BASE_URL + "/staff/can_delete_sale/" + username + "/" + password,
            function (response, status, xhr) {
              // console.log(response)
              if (status == "error") {
                set_feedback(
                  "error",
                  "An Error Occurred! Please contact support",
                  false
                );
              } else {
                if (response == "true") {
                  do_delete($this.attr("href"), selected);
                } else {
                  set_feedback(
                    "error",
                    "Incorrect login credentials! Please Try Again",
                    false
                  );
                }
              }
            }
          );
        }
      }
    } else {
      alertify.alert(none_selected_message);
    }
  });
}

enable_delete.enabled = true;
enable_delete_with_authentication.enabled = true;

function do_delete(url, selected) {
  //If delete is not enabled, don't do anything

  if (!enable_delete.enabled || !enable_delete_with_authentication.enabled)
    return;

  var selected_rows = new Array();

  selected_rows.push(selected);

  $.post(
    url,
    { "ids[]": selected_rows, softtoken: $("#token_hash").val() },
    function (response) {
      //delete was successful, remove checkbox rows
      if (response.success) {
        //get_data();
        set_feedback("success", response.message, false);

        setTimeout(function () {
          location.reload();
        }, 1000);
      } else {
        set_feedback("error", response.message, true);
      }
    },
    "json"
  );
}

function calcTableRowCount(table) {
  var tableContainerParentHeight = $(table.table().container())
    .closest(".table-body")
    .height();
  var tableHeaderFooterheight =
    $(table.table().container()).height() -
    $(table.table().container()).find(".dataTable").height();
  var tableRowHeight = $(table.table().container()).find("tr").first().height();

  var availableTableHeight =
    tableContainerParentHeight - tableHeaderFooterheight;

  var rowCount = Math.floor(availableTableHeight / tableRowHeight) - 1;

  if (rowCount < 5) {
    return 5;
  } else {
    return rowCount;
  }
}
