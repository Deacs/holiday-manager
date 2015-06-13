@extends('master')

@section('content')
    <div class="row">
        <div class="large-2 columns">
            {!! HTML::image($member->getAvatarPath(), $member->fullName()) !!}
        </div>
        <div class="large-5 columns">
            <h2>{!! $member->fullName() !!}</h2>
            <h3>{!! $member->role !!}</h3>
            <h6>{!! HTML::mailto($member->email, $member->email) !!}</h6>
        </div>
        <div class="large-5 columns">
            <h5>Holiday Status :
                @if ($member->onApprovedLeave())
                    Currently on leave - return date :
                @else
                    Not currently on leave
                @endif
            </h5>

            @if ($member->hasApprovedHoliday())
                Next approved holiday start date :
            @else
                No approved holiday requests
            @endif
        </div>
    </div>

    @if (Auth::user() && Auth::user()->id == $member->id)
        @include('member.request-holiday')
    @endif

@endsection
