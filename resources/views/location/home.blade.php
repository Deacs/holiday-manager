@extends('master')

@section('content')

    <div class="large-12 columns">
        <h1>{{ $location->name }}</h1>
    </div>

    <div class="large-6 columns">
        <div class="panel callout radius">
            {!! $location->formattedAddress() !!}
        </div>
    </div>
    <div class="large-2 columns text-right">
        <span class="radius secondary label">{!! $location->telephone !!}</span>
    </div>

@endsection
