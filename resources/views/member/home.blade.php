@extends('master')

@section('content')
    <div class="row">

        <script id="member-profile" type="x-template">

            <div class="large-2 columns">
                <img src="@{{ member | getAvatar '150' }}">
            </div>
            <div class="large-6 columns">
                <h2 v-text="member | nameFormat"></h2>
                <h3><a href="@{{ member.department.url }}" v-text="member.department.name"></a> / <a href="@{{ member.location.name }}" v-text="member.location.name"></a></h3>
                <h4 v-text="member.role"></h4>
            </div>
            <div class="large-4 columns">
                <h3>Contact</h3>
                <ul class="no-bullet">
                    <li><a href="mailto:@{{ member.email }}" v-text="member.email"></a></li>
                    <li v-text="member.telephone"></li>
                    <li v-text="member.extension"></li>
                    <li><a href="skype:@{{ member.skype_name }}?call">Call</a> | <a href="skype:@{{ member.skype_name }}?chat">Chat</a></li>
                </ul>
            </div>

        </script>

        <member_profile slug="{{ $member->slug }}"></member_profile>

    </div>

@endsection
