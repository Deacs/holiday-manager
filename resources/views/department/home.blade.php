@extends('master')

@section('content')

    <div class="large-12 columns">
        <h2>{{ $department->name }}</h2>
    </div>

    <div class="large-12 columns" role="content">
        <h4>Department Lead: {{ $lead->fullName() }}</h4>

        <h5>Team Members</h5>

        @if(count($team))
            @include(Auth::user() ? 'department.member_details' : 'department.member_listing')
        @else
            <div data-alert="" class="alert-box info radius">
                No Team Members associated with {!! $department->name !!}
                <a href="#" class="close">×</a>
            </div>
        @endif
    </div>

@endsection
