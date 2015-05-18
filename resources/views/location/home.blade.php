@extends('master')

@section('content')

    <div class="large-12 columns">
        <h1>{{ $location->name }}</h1>
    </div>

    <div class="large-12 columns" role="content">
        Data for location here
    </div>

@endsection
