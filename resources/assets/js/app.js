var Vue     = require('vue');
var Moment  = require('moment');

Vue.use(require('vue-resource'));

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

Vue.component('department_profile', {

    template: document.querySelector('#department_profile'),

    props: ['slug'],

    data: function() {
        return {
            slug:       '',
            department: ''
        }
    },

    methods: {
        fetchDepartment: require('./methods/fetchDepartment')
    },

    ready: function() {
        this.fetchDepartment(this.slug)
    }

});

Vue.component('member_profile', {

    template: document.querySelector('#member-profile'),

    props: ['slug'],

    data: function() {
        return {
            slug:       '',
            member:     '',
            members:    []
        }
    },

    methods: {
        fetchMember: require('./methods/fetchMember')
    },

    ready: function() {
        this.fetchMember(this.slug);
    }
});

Vue.component('member_listing', {

    template: document.querySelector('#member-listing'),
    //template: require('./templates/member_listing'),

    props: ['dept_name', 'dept_slug', 'flash-data', 'display-flash'],

    data: function() {

        return {
            memberColumns: [
                {field: 'last_name', title: 'Name'},
                {field: 'department_name', title: 'Department'},
                {field: 'role', title: 'Role'},
                {field: 'email', title: 'email'},
                {field: 'telephone', title: 'Telephone'},
                {field: 'extension', title: 'Extension'},
                {field: 'skype_name', title: 'Skype'}
            ],
            dept_slug: '',
            dept_name: '',
            departments: [],
            locations: [],
            members: [],
            sortKey: '',
            reverse: false,
            search: '',
            newMember: {
                first_name: '',
                last_name: '',
                slug: '',
                role: '',
                email: '',
                telephone: null,
                extension: null,
                skype_name: null,
                department_id: '',
                department_name: '',
                location_id: '',
                created_at: Moment()
            },
            flashData: {
                'level': '',
                'message': ''
            },
            displayFlash: false
        }
    },

    methods: {
        fetchDepartments:   require('./methods/fetchDepartments'),
        fetchLocations:     require('./methods/fetchLocations'),
        fetchMembers:       require('./methods/fetchMembers'),
        addNewMember:       require('./methods/addMember'),
        sortBy:             require('./methods/sortBy'),
        makeSlug:           require('./methods/makeSlug')
    },

    ready: function() {

        this.fetchMembers(this.dept_slug);
        this.fetchDepartments();
        this.fetchLocations();
    }

});

new Vue({

    el: '#app',

    methods: {
        fetchLocations:     require('./methods/fetchLocations'),
        fetchDepartments:   require('./methods/fetchDepartments')
    },

    data: {
        displayFlash:       false,
        defaultDate:        '',
        holidayRequests:    [],
        locations:          [],
        departments:        [],
        haveHistory:        false,

        flashData: {
            'level':    '',
            'message':  ''
        }
    },

    filters : {
        getAvatar:  require('./filters/getAvatar'),
        dateFormat: require('./filters/dateFormat'),
        nameFormat: require('./filters/nameFormat')
    },

    ready: function() {
        this.fetchLocations();
        this.fetchDepartments();
    }
});

