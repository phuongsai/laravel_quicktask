@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tasks</h2>
    <div class="card">
      <div class="card-header">
        <!-- Button -->
        <div class="mb-3 float-left">
            <a href="javascript:void(0)" class="btn btn-primary" id="create_new_task"><i class="fa fa-plus"></i> @lang('messages.task.btn_add')</a>
            <a href="javascript:void(0)" class="btn btn-primary" id="list_task" style="display: none;"><i class="fa fa-chevron-left"></i> @lang('messages.task.btn_back')</a>
        </div>
        <div class="mb-3 float-right">
            <a href="javascript:void(0)" class="btn btn-warning" id="trash_task"><i class="fa fa-trash"></i> @lang('messages.task.btn_trash')</a>
        </div>
        <!-- /Button -->
      </div>
        <div class="card-body">
            <!-- DataTable-->
            <div class="table-responsive">
                <div class="justify-content-center text-center">
                    <table class="table table-striped table-hover" id="task_datatable">
                        <thead>
                            <tr>
                                <th>@lang('messages.datatable.no_index')</th>
                                <th>@lang('messages.datatable.name')</th>
                                <th>@lang('messages.datatable.created_at')</th>
                                <th>@lang('messages.datatable.updated_at')</th>
                                <th>@lang('messages.datatable.action')</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- /DataTable-->
        </div>
    </div>
</div>
@endsection

<!-- Bootstrap modal-->
@include('tasks.modal')
