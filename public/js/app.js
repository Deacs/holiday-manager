Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

new Vue({

    data: {
        displayFlash: false
    }
});

new Vue({

    el: '#members',

    data: {
        members: [],
        newMember: {
            first_name: '',
            last_name: '',
            email: '',
            role: '',
            location_id: '',
            department_id: ''
        },

        displayFlash: false
    },

    computed: {
      errors: function() {
          for (var key in this.newMember) {
              if ( ! this.newMember[key]) return true;
          }

          return false;
      }
    },

    ready: function() {
        this.fetchMembers();
    },

    methods: {
        fetchMembers: function() {
            this.$http.get('/api/members', function(members) {
                this.members = members;
            });
        },

        onSubmitForm: function(e) {

            e.preventDefault();

            var member = this.newMember;

            this.members.push(member);
            this.newMember = {
                first_name: '',
                last_name: '',
                email: '',
                role: '',
                location_id: '',
                department_id: ''
            };

            this.$http.post('api/members', member);

            this.flashData = {
                'level': 'success',
                'message': 'Department Member Successfully Added'
            };

            this.displayFlash = true;
        }
    }

});

new Vue({

    el: '#app',

    data: {
        displayFlash: false,

        defaultDate: '',

        holidayRequests: [],

        haveHistory: false,

        newHolidayRequest: {
            user_id: '',
            start_date: '',
            end_date: '',
            status_id: 'Pending',
            approved_by: '',
            declined_by: '',
            created_at: '2012-06-18 17:08:37'
        },

        flashData: {
            'level': '',
            'message': ''
        }
    },

    ready: function() {
        this.fetchHolidayRequests();
    },

    methods: {

        fetchHolidayRequests: function() {

            this.$http.get('/api/member/holiday-requests', function(holidayRequests) {

                this.holidayRequests = holidayRequests;

                this.haveHistory = this.holidayRequests.length;

                console.table(this.holidayRequests);

            });
        },

        requestHoliday: function(e) {

            e.preventDefault();

            var holidayRequest = this.newHolidayRequest;

            this.holidayRequests.push(holidayRequest);

            this.haveHistory = true;

            this.newHolidayRequest = {
                start_date: this.defaultDate,
                end_date: this.defaultDate
            };

            this.$http.post('/api/holiday/request', holidayRequest)
                .success(function (data) {
                    console.log('Success');
                    console.log(data);

                    this.flashData = {
                        'level': data.status,
                        'message': data.message
                    };
                })
                .error(function (data) {
                    this.flashData = {
                        'level': data.status,
                        'message': data.message
                    };
                });

            this.displayFlash = true;
        }
    }
});

//# sourceMappingURL=app.js.map