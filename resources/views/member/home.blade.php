@extends('master')

@section('content')
    <div class="row">
        <div class="large-2 columns">
            {!! HTML::image($member->getAvatarPath(), $member->fullName()) !!}
        </div>
        <div class="large-7 columns">
            <h2>{!! $member->fullName() !!}</h2>
            <h3>{!! $member->role !!}</h3>
            <h6>{!! HTML::mailto($member->email, $member->email) !!}</h6>
        </div>
        <div class="large-2 columns">

            @include('member.holiday-balance')

        </div>
    </div>

    @if (Auth::user() && Auth::user()->id == $member->id)
        @include('member.request-holiday')
        @include('member.holiday-history')
    @endif

@endsection
