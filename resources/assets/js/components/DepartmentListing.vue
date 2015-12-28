<template>

    <h3>Departments</h3>

    <input type="text" v-model="search" placeholder="Start typing any of the fields below to search....">
    <table width="100%">
        <tr>
            <th class="sort-field"
                v-repeat="column: departmentColumns"
                v-on="click: sortBy(column.field)"
                v-class="active-field: sortKey==column.field">
                {{ column.title }}
            </th>
        </tr>
        <tr v-repeat="department: departments
                | filterBy search
                | orderBy sortKey reverse"
        >
            <td><a href="{{ department.url }}" v-text="department.name"></a></td>
            <td><img v-attr="src:department.lead | getAvatar '20'" width="20"> <a href="{{ department.lead.url }}" v-text="department.lead | nameFormat"></a></td>
                <td><a href="mailto:{{ department.lead.email }}" v-text="department.lead.email"></a></td>
                <td v-text="department.lead.telephone"></td>
                <td v-text="department.lead.extension"></td>
                <td v-text="department.lead.skype_name"></td>

            </tr>
        </table>

</template>

<script>

    export default {

        props: ['flashdata', 'displayflash', 'location_slug'],

        data: function() {

            return {
                departmentColumns: [
                    {field: 'name', title: 'Name'},
                    {field: 'lead.last_name', title: 'Lead'},
                    {field: 'lead.email', title: 'email'},
                    {field: 'lead.telephone', title: 'Telephone'},
                    {field: 'lead.extension', title: 'Extension'},
                    {field: 'lead.skype_name', title: 'Skype'}
                ],
                location_slug: '',
                departments: [],
                members: [],
                sortKey: '',
                reverse: false,
                search: ''
            }
        },
        methods: {
            fetchDepartments:           require('../methods/fetchDepartments'),
            sortBy:                     require('../methods/sortBy')
        },
        filters: {
            nameFormat: require('../filters/nameFormat')
        },

        ready: function() {

            var bounds = {};

            if (this.location_slug != '') {
                bounds = {
                    location: this.location_slug
                };
            }

            this.fetchDepartments(bounds);
        }
    }

</script>
