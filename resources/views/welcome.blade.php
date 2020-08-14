@extends('layouts.app')

@section('content')
<div class="content">
    <div class="title m-b-md">
        Laravel QuickStart
    </div>

    <div class="links">
        <a href="{{ route('task.index') }}">Tasks List</a>
    </div>
</div>
@endsection
