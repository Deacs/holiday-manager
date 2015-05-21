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

    <div class="large-12 columns">
        @if (count($departments))
            <ul>
                @foreach ($departments as $department)
                    <li class="department-link">{!! link_to_route('department.home', $department->name, ['slug' => $department->slug]) !!}</li>
                @endforeach
            </ul>
        @else
            <div data-alert="" class="alert-box info radius">
                No Departments associated with {!! $location->name !!}
                <a href="#" class="close">×</a>
            </div>
        @endif
    </div>

@endsection
