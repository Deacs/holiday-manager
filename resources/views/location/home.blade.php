@extends('master')

@section('content')

    <h1>{{ $location->name }}</h1>

    <div class="large-12 columns">
        <input type="hidden" id="loc_lat" value="{{ $location->lat }}">
        <input type="hidden" id="loc_lon" value="{{ $location->lon }}">
    </div>

    <div class="large-6 columns">
        <div class="panel callout radius">
            {!! $location->formattedAddress() !!}
        </div>
    </div>
    <div class="large-2 columns text-right">
        <span class="radius secondary label">{!! $location->telephone !!}</span>
    </div>

    <div class="large-12 columns" id="map_canvas" style="height: 400px">Map missing? Please check your internet connection.</div>

    <div class="large-12 columns">

        <department-listing location_slug="{{ $location->slug }}"></department-listing>

        <member-listing location_slug="{{ $location->slug }}"></member-listing>
    </div>

@endsection

@section('scripts')
<script>
    var map = null;

    function initialize() {
        var loc_lat = document.getElementById("loc_lat").value;
        var loc_lon = document.getElementById("loc_lon").value;

        var myLocLatlng = new google.maps.LatLng(loc_lat, loc_lon);
        var myLocOptions = {
            zoom: 15,
            center: myLocLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var loc_map = new google.maps.Map(document.getElementById("map_canvas"), myLocOptions);
        var iconBase = '/img/';
        var loc_marker = new google.maps.Marker({
            position: myLocLatlng,
            map: loc_map,
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
