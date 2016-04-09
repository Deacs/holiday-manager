var Vue             = require('vue');
var Moment          = require('moment');
var VueAsyncData    = require('vue-async-data');

Vue.use(VueAsyncData);

import MemberListing        from './components/MemberListing.vue';
import MemberProfile        from './components/MemberProfile.vue';
import DepartmentListing    from './components/DepartmentListing.vue';
import UpdateOrgChart       from './components/UpdateOrgChart.vue';
import OrgChart             from './components/OrgChart.vue';

Vue.use(require('vue-resource'));

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

//Vue.config.debug = true;

new Vue({

    el: '#app',

    components: {
        MemberProfile,
        MemberListing,
        DepartmentListing,
        UpdateOrgChart,
        OrgChart
    },

    data: {
        locations:              [],
        departments:            [],
        members:                [],
        showOrgChartUpdate:     false,
        showAddNewMember:       false,
        showAddNewDepartment:   false,
        newMember: {
            first_name:         '',
            last_name:          '',
            slug:               '',
            role:               '',
            email:              '',
            telephone:          null,
            extension:          null,
            skype_name:         null,
            department_id:      '',
            department_name:    '',
            department_url:     '',
            location_id:        ''
        }
    },

    methods: {
        addMember:                  require('./methods/addMember'),
        fetchLocations:             require('./methods/fetchLocations'),
        fetchDepartments:           require('./methods/fetchDepartments'),
        toggleOrgChartPanel:        require('./methods/toggleOrgChartPanel'),
        toggleNewMemberPanel:       require('./methods/toggleNewMemberPanel'),
        toggleNewDepartmentPanel:   require('./methods/toggleNewDepartmentPanel'),
    },

    filters : {
        getAvatar:  require('./filters/getAvatar'),
        dateFormat: require('./filters/dateFormat'),
        nameFormat: require('./filters/nameFormat')
    },

    ready: function() {
        this.fetchLocations();
        this.fetchDepartments();

        console.log('Ready from Base Vue instance');
    }
});

