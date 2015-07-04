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

//Vue.component('add_member', {
//
//    template: document.querySelector('#add-member'),
//
//    data: function() {
//        return {
//            //newMember: {
//            //    first_name: '',
//            //    last_name: '',
//            //    slug: '',
//            //    role: '',
//            //    email: '',
//            //    telephone: '',
//            //    extension: '',
//            //    skype_name: '',
//            //    department_id: 1,
//            //    location_id: 1,
//            //    created_at: Moment()
//            //},
//            //members: []
//        }
//    },
//
//    methods: {
//        //onSubmitForm: function(e) {
//        //
//        //    e.preventDefault();
//        //
//        //    var member = this.newMember;
//        //
//        //    this.members.push(member);
//        //    this.newMember = {
//        //        first_name: '',
//        //        last_name: '',
//        //        slug: '',
//        //        role: '',
//        //        email: '',
//        //        telephone: '',
//        //        extension: '',
//        //        skype_name: '',
//        //        department_id: 1,
//        //        location_id: 1,
//        //        created_at: Moment()
//        //    };
//        //
//        //    //console.log("Submit New Member Form");
//        //    console.log(member);
//        //    console.log(this.members);
//        //    //console.log('*****************');
//        //
//        //    this.$http.post('/api/member/add', member);
//        //
//        //    this.submitted = true;
//        //}
//    }
//});

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
                {field: 'skype_name', title: 'Skype'},
            ],
            department: '',
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
                telephone: '',
                extension: null,
                skype_name: '',
                department_id: '',
                location_id: '',
                created_at: Moment()
            }
        }
    },

    methods: {
        fetchDepartments:   require('./methods/fetchDepartments'),
        fetchLocations:     require('./methods/fetchLocations'),
        fetchMembers:       require('./methods/fetchMembers'),
        addNewMember:       require('./methods/addMember'),
        sortBy:             require('./methods/sortBy'),
        getAvatar:          require('./filters/getAvatar')
    },

    ready: function() {
        this.fetchMembers(this.department);
        this.fetchDepartments();
        this.fetchLocations();
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

