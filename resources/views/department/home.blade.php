@extends('master')

@section('content')

    <div class="large-12 columns">
        <h2>{{ $department->name }}</h2>
    </div>

    <div class="large-12 columns" role="content">
        <h4>Department Lead: {{ $lead->fullName() }}</h4>

        <h6>Team Members</h6>

        @foreach($team as $member)
            <li>{{  $member->fullName() }}</li>
        @endforeach
    </div>

@endsection
