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

        <h3>Departments</h3>

        <script id="department-listing" type="x-template">

            <input type="text" v-model="search" placeholder="Start typing any of the fields below to search....">
            <table width="100%">
                <tr>
                    <th class="sort-field"
                        v-repeat="column: departmentColumns"
                        v-on="click: sortBy(column.field)"
                        v-class="active-field: sortKey==column.field">
                        @{{ column.title }}
                    </th>
                </tr>
                <tr v-repeat="department: departments
                        | filterBy search
                        | orderBy sortKey reverse"
                        >
                    <td><a href="@{{ department.url }}" v-text="department.name"></a></td>
                    <td><img v-attr="src:department.lead | getAvatar '20'" width="20"> <a href="@{{ department.lead.url }}" v-text="department.lead | nameFormat"></a></td>
                    <td><a href="mailto:@{{ department.lead.email }}" v-text="department.lead.email"></a></td>
                    <td v-text="department.lead.telephone"></td>
                    <td v-text="department.lead.extension"></td>
                    <td v-text="department.lead.skype_name"></td>

                </tr>
            </table>

        </script>

        <department_listing location_slug="{{ $location->slug }}"></department_listing>

        <h3>Staff Listing</h3>
        <script id="member-listing" type="x-template">

            <input type="text" v-model="search" placeholder="Start typing any of the fields below to search....">
            <table width="100%">
                <tr>
                    <th class="sort-field"
                        v-repeat="column: memberColumns"
                        v-on="click: sortBy(column.field)"
                        v-class="active-field: sortKey==column.field">
                        @{{ column.title }}
                    </th>
                </tr>
                <tr v-repeat="member: members
                        | filterBy search
                        | orderBy sortKey reverse"
                        >
                    <td><img v-attr="src:member | getAvatar" width="20px"> <a href="@{{ member.url }}" v-text="member | nameFormat"></a></td>
                    <td v-text="member.department_name"></td>
                    <td v-text="member.role"></td>
                    <td><a href="mailto:@{{ email }}" v-text="member.email"></a></td>
                    <td v-text="member.telephone"></td>
                    <td v-text="member.extension"></td>
                    <td v-text="member.skype_name"></td>
                </tr>
            </table>

        </script>

        <member_listing location_slug="{{ $location->slug }}"></member_listing>
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
