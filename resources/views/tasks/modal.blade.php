<!-- Create/Update Modal -->
<div class="modal fade" id="taskModal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="taskModalTitle"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="taskForm" name="taskForm" class="form-horizontal">
                <div class="modal-body">
                    <div class="alert alert-warning alert-dismissible fade show">
                        <button type="button" class="close" data-hide="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div id="alert_msg" role="alert"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">@lang('messages.modal.name')</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" data-rule-required="true" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-sm-2 control-label">@lang('messages.modal.description')</label>
                        <div class="col-sm-12">
                            <textarea class="form-control" name="description" id="description" cols="10" rows="3"></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="task_id" id="task_id" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('messages.modal.btn_close')</button>
                    <button type="submit" type="button" class="btn btn-primary" id="btn_save" value="create">@lang('messages.modal.btn_save')</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Confirm Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('messages.modal.confirm_label')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4 style="margin: 0;" id="confirmModalTitle">@lang('messages.modal.confirm_title')</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.modal.btn_cancel')</button>
                <button type="button" name="btn_ok" id="btn_ok" class="btn btn-danger">@lang('messages.modal.btn_ok')</button>
            </div>
        </div>
    </div>
</div>
