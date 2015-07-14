@extends('master')

@section('content')

    <div class="large-12 columns">
        <h1>{{ $location->name }}<button data-reveal-id="addLocation" class="button round right">Add New Location</button></h1>
        <input type="hidden" id="loc_lat" value="{{ $location->lat }}">
        <input type="hidden" id="loc_lon" value="{{ $location->lon }}">
    </div>

    <div id="addLocation" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
        <script id="add-location" type="x-template">
            <form method="POST" action="/api/location/add" v-on="submit: addNewLocation">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <h4 id="modalTitle">Add New Location</h4>
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
                <input type="text" name="lat" id="new_loc_lat" style="width:45%;" class="left" />
                <input type="text" name="lon" id="new_loc_lon" style="width:45%;" class="right" />
                <div class="large-12 columns"  id="new_location_map" style="height:400px;"></div>
                <a class="close-reveal-modal" aria-label="Close">&#215;</a>
                <div class="large-12 columns">
                    <button class="button round success right">Add Location</button>
                </div>
            </form>
        </script>

        <add_location></add_location>

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
    var map = null;
    var new_loc_marker = null;

    // A function to create the marker and set up the event window function
    function createMarker(latlng) {

        var marker = new google.maps.Marker({
            position: latlng,
            map: new google.maps.Map(document.getElementById("new_location_map")),
            icon: '/img/map_marker.png'
        });

        google.maps.event.trigger(marker, 'click');
        return marker;
    }

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

        // New Location init
        var newLocOptions = {
            zoom: 8,
            center: new google.maps.LatLng(50.476303, -3.5230705),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var new_loc_map = new google.maps.Map(document.getElementById("new_location_map"), newLocOptions);

        google.maps.event.addListener(new_loc_map, 'click', function( event ){
            document.getElementById("new_loc_lat").value = event.latLng.lat();
            document.getElementById("new_loc_lon").value = event.latLng.lng();

            var newLocLatLng = new google.maps.LatLng(event.latLng.lat(), event.latLng.lng());

            if (new_loc_marker) {
                new_loc_marker.setMap(null);
                new_loc_marker = null;
            }

            var iconBase = '/img/';
            new_loc_marker = new google.maps.Marker({
                position: newLocLatLng,
                map: new_loc_map,
                title: 'Crowdcube',
                icon: iconBase + 'map_marker.png'
            });
            new_loc_map.setCenter(new_loc_marker.getPosition());
        });


//        google.maps.event.trigger(new_loc_marker, 'click');
//            return new_loc_marker;
//        });



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
