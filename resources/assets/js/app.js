var Vue     = require('vue');
var Moment  = require('moment');

Vue.use(require('vue-resource'));

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

var departmentProfile = Vue.extend({

    template:'#department_profile',

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
        this.fetchDepartment(this.slug);
    }
});

var MemberProfile = Vue.extend({

    template: '#member-profile',

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


var MemberListing = Vue.extend({

    template: '#member-listing',

    //template: require('./templates/member-listing.html'),

    props: ['dept_name', 'dept_slug', 'flashdata', 'displayflash'],

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
            flashdata: {
                'level': '',
                'message': 'Standard'
            },
            displayflash: true
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

var AddLocation = Vue.extend({

    template: '#add-location',

    data: function() {

        return {
            newLocation: {
                name: '',
                address: '',
                telephone: null,
                lat: '',
                lon: '',
                created_at: Moment()
            },
            flashdata: {
                'level': '',
                'message': 'Standard'
            },
            displayflash: true
        }

    },

    methods: {
        addLocation: require('./methods/addLocation')
    }

});

Vue.component('department_profile', departmentProfile);
Vue.component('member_profile', MemberProfile);
Vue.component('member_listing', MemberListing);
Vue.component('add_location', AddLocation);

new Vue({

    el: '#app',

    data: {
        displayflash:       false,
        defaultDate:        '',
        holidayRequests:    [],
        locations:          [],
        departments:        [],
        haveHistory:        false,

        flashdata: {
            'level':    '',
            'message':  ''
        }
    },

    methods: {
        fetchLocations:     require('./methods/fetchLocations'),
        fetchDepartments:   require('./methods/fetchDepartments'),

        updateFlash: function(vis, level, msg) {
            this.displayflash       = vis;
            this.flashdata.level    = level;
            this.flashdata.msg      = msg;
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

