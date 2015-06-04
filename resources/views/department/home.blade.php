@extends('master')

@section('content')

    <div class="large-12 columns">
        <h1>{{ $department->name }}</h1>
    </div>

    <div class="large-12 columns" role="content">
        <h4>{!! HTML::image($lead->getAvatarPath(30), $lead->fullName()) !!} Department Lead: {{ $lead->fullName() }}</h4>

        @if (Auth::user()->isDepartmentLead($department))

            @include('department.add-member')

        @endif

        <h5>Team Members</h5>

        @if(count($team))
            @include(Auth::user()->hasManageHolidayRequestPermission($department) ? 'department.member_details' : 'department.member_listing')
        @else
            <div data-alert="" class="alert-box info radius">
                No Team Members associated with {!! $department->name !!}
                <a href="#" class="close">×</a>
            </div>
        @endif
    </div>

@endsection
