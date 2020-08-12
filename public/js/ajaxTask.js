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
