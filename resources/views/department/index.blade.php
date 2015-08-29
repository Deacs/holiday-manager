@extends('master')

@section('content')

    <h1>Departments</h1>

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
                <td v-text="department.name"></td>
                <td v-text="department.lead.first_name"></td>
                <td v-text="department.lead.email"></td>
                <td v-text="department.lead.telephone"></td>
                <td v-text="department.lead.extension"></td>
                <td v-text="department.lead.skype_name"></td>

            </tr>
        </table>

    </script>

    <department_listing></department_listing>

@endsection
