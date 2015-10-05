@extends('master')

@section('content')

    @can('add-locations')

        <h1>Add new Location</h1>

        <form method="POST" action="/locations/add">
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <div class="large-12 columns">
                <div class="large-2 left"><label for="loc_name">Name</label></div>
                <div class="large-10 right"><input type="text" id="loc_name" name="name" placeholder="Crowdcube Towers"></div>
            </div>
            <div class="large-12 columns">
                <div class="large-2 left"><label for="loc_address">Address</label></div>
                <div class="large-10 right"><input type="text" id="loc_address" name="address" placeholder="Separate each line with a comma"></div>
            </div>
            <div class="large-12 columns">
                <div class="large-2 left"><label for="loc_telephone">Telephone</label></div>
                <div class="large-10 right"><input type="tel" id="loc_telephone" name="telephone" placeholder="01392 123456"></div>
            </div>
            <input type="text" name="lat" id="loc_lat" style="width:45%;" class="left" />
            <input type="text" name="lon" id="loc_lon" style="width:45%;" class="right" />
            <div class="large-12 columns" id="map_canvas" style="height:400px;">MAP DIV</div>
            <div class="large-12 columns">
                <button class="button round success right">Add Location</button>
            </div>
        </form>

    @else

        <div class="alert-box alert">Only Super Users are permitted to add new Locations</div>

    @endcan

@endsection

@can('add-locations')
    @section('scripts')
    <script>
        var map         = null;
        var loc_marker  = null;

        // A function to create the marker and set up the event window function
        function createMarker(latlng) {

            var marker = new google.maps.Marker({
                position: latlng,
                map: new google.maps.Map(document.getElementById("map_canvas")),
                icon: '/img/map_marker.png'
            });

            google.maps.event.trigger(marker, 'click');
            return marker;
        }

        function initialize() {
            var loc_lat = document.getElementById("loc_lat").value;
            var loc_lon = document.getElementById("loc_lon").value;

            var myLocLatlng = new google.maps.LatLng(50.476303, -3.5230705);
            var myLocOptions = {
                zoom: 8,
                center: new google.maps.LatLng(50.476303, -3.5230705),
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
            loc_map.setCenter(loc_marker.getPosition());

            google.maps.event.addListener(loc_map, 'click', function( event ) {

                document.getElementById("loc_lat").value = event.latLng.lat();
                document.getElementById("loc_lon").value = event.latLng.lng();

                var newLocLatLng = new google.maps.LatLng(event.latLng.lat(), event.latLng.lng());

                if (loc_marker) {
                    loc_marker.setMap(null);
                    loc_marker = null;
                }

                var iconBase = '/img/';
                loc_marker = new google.maps.Marker({
                    position: newLocLatLng,
                    map: loc_map,
                    title: 'Crowdcube',
                    icon: iconBase + 'map_marker.png'
                });
                loc_map.setCenter(loc_marker.getPosition());
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
@endcan
