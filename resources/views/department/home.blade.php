@extends('master')

@section('content')

    <div class="large-12 columns">
        <h2>{{ $department->name }}</h2>
    </div>

    <div class="large-12 columns" role="content">
        <h4>{!! HTML::image($department->lead->getAvatarPath(30), $department->lead->fullName()) !!} Department Lead: <a href="{{ $department->lead->url }}" class="department-lead">{{ $department->lead->fullName() }}</a></h4>

        <h5>Team Members</h5>

        <script id="member-listing" type="x-template">

            @if (Auth::user()->hasManageDepartmentPermission($department))

            <h4>Add New Team Member</h4>

                @include('notifications.result')

                @include('department.add_user')

                <hr />

            @endif

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
