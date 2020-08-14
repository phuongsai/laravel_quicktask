var SITEURL = window.location.origin;
var jq = new jQuery();
/* dataTable AJAX */
(function () {
    $.fn.data_table = function (string = "") {
        $("#task_datatable").DataTable({
            autoWidth: false,
            destroy: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: SITEURL + string,
                type: "GET",
            },
            columns: [{
                    data: "DT_RowIndex",
                    name: "DT_RowIndex"
                }, // 0
                {
                    data: "name",
                    name: "name"
                },
                {
                    data: "created_at",
                    name: "created_at"
                },
                {
                    data: "updated_at",
                    name: "updated_at"
                },
                {
                    data: "action",
                    name: "action",
                    render: function (data, type, row, meta) {
                        if (row.deleted_at == null) {
                            btn = '<a href="javascript:void(0);" id="edit_task" data-id="' + row.id + '" data-toggle="tooltip" data-original-title="Edit" class="btn btn-icon btn-info"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                            btn += '&nbsp;<a href="javascript:void(0);" id="delete_task" data-id="' + row.id + '" data-toggle="tooltip" data-original-title="Delete" class="btn btn-icon btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        } else {
                            btn = '<a href="javascript:void(0);" id="restore_task" data-id="' + row.id + '" data-toggle="tooltip" data-original-title="Restore" class="btn btn-icon btn-warning"><i class="fa fa-undo" aria-hidden="true"></i></a>';
                            btn += '&nbsp;<a href="javascript:void(0);" id="permanent_delete_task" data-id="' + row.id + '" data-toggle="tooltip" data-original-title="Delete Permanently" class="btn btn-icon btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        }

                        return btn;
                    }
                }, // 4
            ],
            columnDefs: [{
                    orderable: false,
                    targets: [0, 4]
                },
                {
                    searchable: false,
                    targets: [0, 2, 3, 4]
                }
            ],
            order: [
                [0, "desc"]
            ],
        });
    };
})(jQuery);

/* Initial dataTable AJAX when document is ready*/
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    jq.data_table("/task");
});

/* Show all records or soft delete records */
$("body").on("click", "#trash_task, #list_task", function () {
    $("#task_datatable").DataTable().clear();
    var data_type = $(this).attr("id");
    if (data_type == "trash_task") {
        $(this).hide();
        $('#create_new_task').hide();
        $('#list_task').show();
        jq.data_table("/api/task/trash");
    } else {
        $(this).hide();
        $('#trash_task').show();
        $('#create_new_task').show();
        jq.data_table("/task");
    }
});

/* Show Edit/Create Modal */
$("body").on("click", "#edit_task, #create_new_task", function () {
    // $.resetValidate(); // critical error cause reload page =.=
    $(".alert-warning").hide();
    modal_type = $(this).attr("id");
    if (modal_type == "create_new_task") {
        $("#task_id").val("");
        $("#taskForm").trigger("reset");
        $("#taskModalTitle").html("Add New Task");
        $("#btn_save").html("Create");
        $("#taskModal").modal({
            show: true,
            backdrop: "static",
            keyboard: false,
        });
    } else {
        // Get detail record form server
        var task_id = $(this).data("id");
        $.get(SITEURL + "/api/task/edit/" + task_id, function (value) {
            $("#taskModalTitle").html("Edit Task");
            $("#btn_save").html("Update");
            $("#taskModal").modal({
                show: true,
                backdrop: "static",
                keyboard: false,
            });
            $("#task_id").val(value.data.id);
            $("#name").val(value.data.name);
            $("#description").val(value.data.description);
        });
    }
});

/* Show confirm modal */
$("body").on("click", "#delete_task, #restore_task, #permanent_delete_task", function () {
    task_id = $(this).data("id");
    url_delete = $(this).attr("id");
    switch (url_delete) {
        case "restore_task":
            $("#confirmModalTitle").html("Are you sure you want to restore this data?");
            break;
        case "permanent_delete_task":
            $("#confirmModalTitle").html("Are you sure you want to permanently delete this data?");
            break;
        default:
            break;
    }
    $("#confirmModal").modal("show");
});

/* Confirmation related to delete or restore task */
$("#btn_ok").click(function () {
    var url_action = "";
    var url_type = "DELETE";
    var msg = "Deleting...";
    switch (url_delete) {
        case "permanent_delete_task":
            url_action = "forceDelete/";
            break;
        case "restore_task":
            url_action = "restoreTrash/";
            url_type = "PATCH";
            msg = "Restoring...";
            break;
        default:
            url_action = "delete/";
            break;
    }
    $.ajax({
        type: url_type,
        url: SITEURL + "/api/task/" + url_action + task_id,
        contentType: 'application/json',
        beforeSend: function () {
            $("#btn_ok").text(msg);
        },
        success: function (data) {
            if (data.errors) {
                $("#alert_msg").empty();
                $.each(data.errors, function (key, value) {
                    $("#alert_msg").append("<strong><li>" + value + "</li></strong>");
                    $(".alert-warning").show();
                });
            } else {
                $("#task_datatable").dataTable().fnDraw(false);
                setTimeout(function () {
                    $(".alert-warning").hide();
                    $("#confirmModal").modal("hide");
                    $("#btn_ok").html("OK");
                    $.msgNotification("success", data.success);
                }, 1000);
            }
        },
    });
});

/* Validate input data + send form to updateOrCreate */
$("#btn_save").click(function () {
    $("#taskForm").validate({
        rules: {
            name: {
                required: true,
                minlength: 1,
                maxlength: 255,
            },
            description: {
                maxlength: 255,
            },
        },
        messages: {
            name: {
                required: "Name is required!",
                minlength: "Minimum length is 1!",
                maxlength: "Maximum length is 255!",
            },
            description: {
                maxlength: "Maximum length is 255.",
            },
        },
        submitHandler: function () {
            $("#btn_save").html("Saving..");
            $.ajax({
                data: $("#taskForm").serialize(),
                url: SITEURL + "/api/task/store",
                type: "POST",
                dataType: "json",
                success: function (data) {
                    $(".alert-warning").hide();
                    if (data.errors) {
                        $("#alert_msg").empty();
                        $.each(data.errors, function (key, value) {
                            $("#alert_msg").append("<strong><li>" + value + "</li></strong>");
                            $(".alert-warning").show();
                        });
                        $("#btn_save").html("Save Changes");
                    } else {
                        $("#task_datatable").DataTable().ajax.reload();
                        setTimeout(function () {
                            $("#taskForm").trigger("reset");
                            $("#taskModal").modal("hide");
                            $("#btn_save").html("Save Changes");
                            $.msgNotification("success", data.success);
                        }, 1000);
                    }
                },
                error: function (data) {
                    var validateErrors = data.responseJSON.errors;
                    $("#alert_msg").empty();
                    $.each(validateErrors, function (key, value) {
                        $("#alert_msg").append("<strong><li>" + value + "</li></strong>");
                        $(".alert-warning").show();
                    });
                    $("#btn_save").html("Save Changes");
                },
            });
        },
    });
});

/* Remove validate error */
(function () {
    $.resetValidate = function () {
        var validator = $("#taskForm").validate();
        validator.resetForm();
    };
})(jQuery);

/* Hide errors showed on modal when click close button*/
$(function () {
    $("[data-hide]").on("click", function () {
        $(this).closest("." + $(this).attr("data-hide")).hide();
    });
});

/* Capitalize first letter for Toast Nofitication*/
$(function () {
    $.jsUcFirst = function (string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    };
});

// toastr settings
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

/* Toast Nofitication*/
$(function () {
    $.msgNotification = function (msgType, msgText) {
        toastr[msgType]($.jsUcFirst(msgText));
    };
});
