Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

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

        submitted: false,
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

            this.submitted = true;
        }
    }

});

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

new Vue({

    el: '#app',

    data: {
        holidayRequestSubmitted: false,

        defaultDate: '',

        result: {
            'level': '',
            'message': ''
        }
    },

    methods: {

        requestHoliday: function(e) {

            e.preventDefault();

            var holidayRequest = this.newHolidayRequest;

            this.newHolidayRequest = {
                start_date: this.defaultDate,
                end_date: this.defaultDate
            };

            this.$http.post('/api/holiday/request', holidayRequest);

            this.result = {
                'level': 'success',
                'message': 'Holiday Request Successfully Placed'
            };

            this.holidayRequestSubmitted = true;
        }
    }
});

//# sourceMappingURL=app.js.map