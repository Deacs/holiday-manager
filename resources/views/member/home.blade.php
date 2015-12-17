@extends('master')

@section('content')
    <div class="row">
        <member-profile member_slug="{{ $member->slug }}" user_slug="{{ Auth::user()->slug }}"></member-profile>
    </div>

@endsection
