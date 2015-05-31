@extends('master')

@section('content')

    <div class="large-12 columns">
        <h1>Staff Directory</h1>
    </div>

    <div class="large-12 columns" role="content">
        @if (count($members))
            <ul class="no-bullet">
            @foreach ($members as $member)
                <li>{!! HTML::image($member->getAvatarPath(30), $member->fullName()) !!} {!! $member->fullName() !!}</li>
            @endforeach
            </ul>
        @else
            <div data-alert="" class="alert-box info radius">
                No Team Members associated with {!! $department->name !!}
                <a href="#" class="close">×</a>
            </div>
        @endif
    </div>

@endsection
