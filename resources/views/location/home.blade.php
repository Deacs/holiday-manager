@extends('master')

@section('content')

    <div class="large-12 columns">
        <h1>{{ $location->name }}</h1>
    </div>

    <div class="large-6 columns">
        {!! $location->formattedAddress() !!}
    </div>
    <div class="large-2 columns text-right">
        {!! $location->telephone !!}
    </div>

@endsection
