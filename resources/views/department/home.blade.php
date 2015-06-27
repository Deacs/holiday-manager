@extends('master')

@section('content')

    <div class="large-12 columns">
        <h2>{{ $department->name }}</h2>
    </div>

    <div class="large-12 columns" role="content">
        <h4>{!! HTML::image($department->lead->getAvatarPath(30), $department->lead->fullName()) !!} Department Lead: {{ $department->lead->fullName() }}</h4>

        @if (Auth::user()->isDepartmentLead($department))

            <hr />

            @include('member.add', ['department_id' => $department->id])

        @endif

        <h5>Team Members</h5>

        <script id="member-listing" type="x-template">

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
                    <td><img src="@{{ member | getAvatar '20' }}"> <a href="@{{ member.url }}" v-text="member | nameFormat"></a></td>
                    <td v-text="member.department_name"></td>
                    <td v-text="member.role"></td>
                    <td><a href="mailto:@{{ email }}" v-text="member.email"></a></td>
                    <td v-text="member.telephone"></td>
                    <td v-text="member.extension"></td>
                </tr>
            </table>

        </script>

        <member_listing department="{{ $department->name }}"></member_listing>

    </div>

@endsection
