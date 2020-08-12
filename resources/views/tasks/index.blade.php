@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tasks</h2>
    <div class="card">
      <div class="card-header">
        <!-- Button -->
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
