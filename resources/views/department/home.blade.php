@extends('master')

@section('content')

    <div class="large-12 columns">
        <h1>{{ $department->name }}</h1>
    </div>

    <div class="large-12 columns" role="content">
        Department Content Here
    </div>

@endsection
