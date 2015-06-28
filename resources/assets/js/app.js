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
            slug:   '',
            member: ''
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

    props: ['department'],

    data: function() {
        return {
            memberColumns: [
                {field: 'last_name', title: 'Name'},
                {field: 'department_name', title: 'Department'},
                {field: 'role', title: 'Role'},
                {field: 'email', title: 'email'},
                {field: 'telephone', title: 'Telephone'},
                {field: 'extension', title: 'Extension'},
            ],
            department: '',
            members: [],
            sortKey: '',
            reverse: false,
            search: ''
        }
    },

    methods: {
        fetchMembers: require('./methods/fetchMembers'),
        sortBy: require('./methods/sortBy')
    },

    ready: function() {
        this.fetchMembers(this.department);
    }

});

new Vue({

    el: '#app',

    data: {
        displayFlash:       false,
        defaultDate:        '',
        holidayRequests:    [],
        locations:          [],
        departments:        [],
        haveHistory:        false,

        newHolidayRequest: {
            user_id: '',
            start_date: '',
            end_date: '',
            status_id: 'Pending',
            approved_by: '',
            declined_by: '',
            created_at: Moment()
        },

        flashData: {
            'level': '',
            'message': ''
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
    },

    methods: {
        fetchLocations:     require('./methods/fetchLocations'),
        fetchDepartments:   require('./methods/fetchDepartments')
    }
});

