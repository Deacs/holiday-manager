@extends('master')

@section('content')

    <div class="large-12 columns">
        <h1>{{ $location->name }}</h1>
        <input type="hidden" id="lat" value="{{ $location->lat }}">
        <input type="hidden" id="lon" value="{{ $location->lon }}">
    </div>

    <div class="large-6 columns">
        <div class="panel callout radius">
            {!! $location->formattedAddress() !!}
        </div>
    </div>
    <div class="large-2 columns text-right">
        <span class="radius secondary label">{!! $location->telephone !!}</span>
    </div>

    <div class="large-12 columns" id="map_canvas" style="height: 400px">MAP HERE</div>

    @include('location.listing')

    <hr />

    @include('department.listing')

    <hr />

    @include('member.listing')





    <div class="large-12 columns">
        @if (count($departments))
            <ul>
                @foreach ($departments as $department)
                    <li class="department-link">{!! link_to_route('department.home', $department->name, ['slug' => $department->slug]) !!}</li>
                @endforeach
            </ul>
        @else
            <div data-alert="" class="alert-box info radius">
                No Departments associated with {!! $location->name !!}
                <a href="#" class="close">×</a>
            </div>
        @endif
    </div>


@endsection

@section('scripts')
<script>
    function initialize() {
        var lat = document.getElementById("lat").value;
        var lon = document.getElementById("lon").value;

        var myLatlng = new google.maps.LatLng(lat, lon);
        var myOptions = {
            zoom: 15,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
        var iconBase = '/img/';
        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title: 'Crowdcube',
            icon: iconBase + 'map_marker.png'
        });
    }

    function loadScript() {
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.src = "http://maps.google.com/maps/api/js?sensor=false&callback=initialize";
        document.body.appendChild(script);
    }

    window.onload = loadScript;
</script>
@endsection
