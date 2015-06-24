var Vue     = require('vue');
var Moment  = require('moment');

Vue.use(require('vue-resource'));

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

new Vue({
    data: {
        displayFlash: false
    }
});

//new Vue({
//
//    el: '#members',
//
//    data: {
//        members: [],
//        newMember: {
//            first_name: '',
//            last_name: '',
//            email: '',
//            role: '',
//            location_id: '',
//            department_id: ''
//        },
//
//        displayFlash: false
//    },
//
//    computed: {
//        errors: function() {
//            for (var key in this.newMember) {
//                if ( ! this.newMember[key]) return true;
//            }
//
//            return false;
//        }
//    },
//
//    ready: function() {
//        this.fetchMembers();
//    },
//
//    methods: {
//        fetchMembers: function() {
//            this.$http.get('/api/members', function(members) {
//                this.members = members;
//            });
//        },
//
//        onSubmitForm: function(e) {
//
//            e.preventDefault();
//
//            var member = this.newMember;
//
//            this.members.push(member);
//            this.newMember = {
//                first_name: '',
//                last_name: '',
//                email: '',
//                role: '',
//                location_id: '',
//                department_id: ''
//            };
//
//            this.$http.post('api/members', member);
//
//            this.flashData = {
//                'level': 'success',
//                'message': 'Department Member Successfully Added'
//            };
//
//            this.displayFlash = true;
//        }
//    }
//
//});

// -------------------------------

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
        displayFlash: false,

        defaultDate: '',

        holidayRequests: [],
        locations: [],
        departments: [],

        haveHistory: false,

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

        getAvatar: require('./filters/getAvatar'),
        dateFormat: require('./filters/dateFormat'),
        nameFormat: require('./filters/nameFormat')
    },

    ready: function() {
        this.fetchLocations();
        this.fetchDepartments();
    },

    methods: {

        //fetchMembers: require('./methods/fetchMembers'),
        //sortBy: require('./methods/sortBy'),
        fetchLocations: require('./methods/fetchLocations'),
        fetchDepartments: require('./methods/fetchDepartments')
        //fetchHolidayRequests: function() {
        //    this.$http.get('/api/member/holiday-requests', function(holidayRequests) {
        //        this.holidayRequests = holidayRequests;
        //        this.haveHistory = this.holidayRequests.length;
        //    });
        //},

        //fetchLocations: function() {
        //    this.$http.get('/api/locations', function(locations) {
        //        this.locations = locations;
        //    });
        //},

        //fetchDepartments: function() {
        //    this.$http.get('/api/departments', function(departments) {
        //        this.departments = departments;
        //    });
        //},

        //fetchMembers: function() {
        //    this.$http.get('/api/members', function(members) {
        //        this.members = members;
        //    });
        //},

        //requestHoliday: function(e) {
        //
        //    e.preventDefault();
        //
        //    var holidayRequest = this.newHolidayRequest;
        //
        //    this.holidayRequests.push(holidayRequest);
        //
        //    this.haveHistory = true;
        //
        //    this.newHolidayRequest = {
        //        start_date: this.defaultDate,
        //        end_date: this.defaultDate
        //    };
        //
        //    this.$http.post('/api/holiday/request', holidayRequest)
        //        .success(function (data) {
        //            console.log('Success');
        //            console.log(data);
        //
        //            this.flashData = {
        //                'level': data.status,
        //                'message': data.message
        //            };
        //        })
        //        .error(function (data) {
        //            this.flashData = {
        //                'level': data.status,
        //                'message': data.message
        //            };
        //        });
        //
        //    this.displayFlash = true;
        //},

        //sortBy: function(sortKey) {
        //
        //    this.reverse = (sortKey == this.sortKey) ? ! this.reverse : false;
        //    this.sortKey = sortKey;
        //}
    }
});

