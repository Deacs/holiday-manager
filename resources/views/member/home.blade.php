@extends('master')

@section('content')

    <div class="large-2 columns">
        {!! HTML::image($member->getAvatarPath(), $member->fullName()) !!}
    </div>
    <div class="large-7 columns">
        <h1>{!! $member->fullName() !!}</h1>
        <h3>{!! $member->role !!}</h3>
        <h6>{!! HTML::mailto($member->email, $member->email) !!}</h6>
    </div>
    <div class="large-3 columns">

    </div>

    <div class="large-12 columns">
        <h5>Holiday Status :
        @if ($member->onApprovedLeave())
            Currently on leave - return date :
        @else
            Not currently on leave
        @endif
        </h5>
    </div>

    <div class="large-12 columns">
        @if ($member->hasApprovedHoliday())
            Next approved holiday start date :
        @else
            No approved holiday requests
        @endif
    </div>

    @if (Auth::user() && Auth::user()->id == $member->id)
        @include('member.request-holiday')
    @endif

@endsection
