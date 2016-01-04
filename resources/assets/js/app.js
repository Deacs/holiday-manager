var Vue             = require('vue');
var Moment          = require('moment');
var VueAsyncData    = require('vue-async-data');

Vue.use(VueAsyncData);

import MemberListing        from './components/MemberListing.vue';
import MemberProfile        from './components/MemberProfile.vue';
import DepartmentListing    from './components/DepartmentListing.vue';

Vue.use(require('vue-resource'));

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

new Vue({

    el: '#app',

    components: {
        MemberProfile,
        MemberListing,
        DepartmentListing
    },

    data: {
        defaultDate:        '',
        holidayRequests:    [],
        locations:          [],
        departments:        [],
        haveHistory:        false,
        showOrgChartUpdate: false,
        showAddNewMember:   false
    },

    methods: {
        fetchLocations:         require('./methods/fetchLocations'),
        fetchDepartments:       require('./methods/fetchDepartments'),
        toggleOrgChartPanel:    require('./methods/toggleOrgChartPanel'),
        toggleNewMemberPanel:   require('./methods/toggleNewMemberPanel')
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

