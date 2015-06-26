var Vue     = require('vue');
var Moment  = require('moment');

Vue.use(require('vue-resource'));

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

Vue.component('member_listing', {

    template: document.querySelector('#member-listing'),
    //template: require('./templates/member_listing'),

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
        this.fetchMembers();
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

