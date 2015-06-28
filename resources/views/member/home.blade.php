@extends('master')

@section('content')
    <div class="row">

        <script id="member-profile" type="x-template">

            <div class="large-2 columns">
                <img src="@{{ member | getAvatar '200' }}">
            </div>
            <div class="large-6 columns">
                <h2 v-text="member | nameFormat"></h2>
                <h5><i class="fi-torso large"></i> @{{ member.role }}</h5>
                <h6><i class="fi-torsos-all large"></i> <a href="@{{ member.department.url }}" v-text="member.department.name"></a></h6>
                <h6><i class="fi-compass"></i> <a href="@{{ member.location.name }}" v-text="member.location.name"></a></h6>
            </div>
            <div class="large-4 columns">
                <h4>Contact</h4>
                <ul class="no-bullet">
                    <li><i class="fi-mail large"></i> <a href="mailto:@{{ member.email }}" v-text="member.email"></a></li>
                    <li><i class="fi-telephone large"></i> @{{ member.telephone }}</li>
                    <li><i class="fi-thumbnails large"></i> @{{ member.extension }}</li>
                    <li><i class="fi-social-skype large"></i> <a href="skype:@{{ member.skype_name }}?call">Call</a> | <a href="skype:@{{ member.skype_name }}?chat">Chat</a></li>
                </ul>
            </div>

        </script>

        <member_profile slug="{{ $member->slug }}"></member_profile>

    </div>

@endsection
