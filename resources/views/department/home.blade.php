@extends('master')

@section('content')

    <div class="large-12 columns">
        <h2>{{ $department->name }}</h2>
    </div>

    <div class="large-12 columns" role="content">
        <h4>{!! HTML::image($department->lead->getAvatarPath(30), $department->lead->fullName()) !!} Department Lead: <a href="{{ $department->lead->url }}">{{ $department->lead->fullName() }}</a></h4>

        <h5>Team Members</h5>

        <script id="member-listing" type="x-template" src="/js/member-listing.js">

            <h4>Add New Team Member</h4>

            @include('notifications.result')

            <form method="POST" v-on="submit: addNewMember">

                <div class="row panel radius">
                    <div class="large-4 columns">
                        <label>First Name</label>
                        <input type="text" placeholder="Jamie" name="first_name" v-model="newMember.first_name">
                    </div>
                    <div class="large-4 columns">
                        <label>Last Name</label>
                        <input type="text" placeholder="Doe" name="last_name" v-model="newMember.last_name">
                    </div>
                    <div class="large-4 columns">
                        <label>Role</label>
                        <input type="text" placeholder="Analyst" name="role" v-model="newMember.role">
                    </div>

                    <div class="large-3 columns">
                        <label>email address</label>
                        <input type="text" placeholder="jamie.doe@crowdcube.com" name="email" v-model="newMember.email">
                    </div>

                    <div class="large-3 columns">
                        <label>Skype Name</label>
                        <input type="text" placeholder="jamiedoe.crowdcube" name="skype_name" v-model="newMember.skype_name">
                    </div>

                    <div class="large-2 columns">
                        <label>Telephone</label>
                        <input type="text" placeholder="01392 123456" name="telephone" v-model="newMember.telephone">
                    </div>

                    <div class="large-1 columns">
                        <label>Ext.</label>
                        <input type="text" placeholder="123" name="extension" v-model="newMember.extension">
                    </div>
                    <div class="large-3 columns">
                        <label>Location</label>

                        <select name="location_id" v-model="newMember.location_id">
                            <option>Select a Location</option>
                            <option v-repeat="location: locations" value="@{{ location.id }}">@{{ location.name }}</option>
                        </select>
                        <input type="hidden" name="department_id" value="{{ $department->id }}" v-model="newMember.department_id">
                        <input type="hidden" name="department_name" value="{{ $department->name }}" v-model="newMember.department_name">

                    </div>

                    <div class="large-12 columns">
                        <button class="small button" title="Add">Add</button>
                    </div>
                </div>

            </form>

            <hr />

            <input type="text" v-model="search">
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
                    <td><img v-attr="src:member | getAvatar '20'" width="20"> <a href="@{{ member.url }}" v-text="member | nameFormat"></a></td>
                    <td v-text="member.department_name"></td>
                    <td v-text="member.role"></td>
                    <td><a href="mailto:@{{ email }}" v-text="member.email"></a></td>
                    <td v-text="member.telephone"></td>
                    <td v-text="member.extension"></td>
                    <td v-text="member.skype_name"></td>
                </tr>
            </table>

        </script>

        <member_listing dept_slug="{{ $department->slug }}" dept_name="{{ $department->name }}"></member_listing>

    </div>

@endsection
