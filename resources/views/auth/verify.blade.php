@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('messages.verify.msg_email')</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            @lang('messages.verify.msg_notify_send')
                        </div>
                    @endif

                    @lang('messages.verify.msg_notify_check')
                    @lang('messages.verify.msg_notify_problem'),
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">@lang('messages.verify.msg_request_another')</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
