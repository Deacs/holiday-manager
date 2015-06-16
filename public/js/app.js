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

        flashData: {
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

            var res = this.$http.post('/api/holiday/request', holidayRequest);

            console.log(res);

            this.flashData = {
                'level': 'success',
                'message': 'Holiday Request Successfully Placed'
            };

            console.log('Update and show Flash');

            this.displayFlash = true;
        }
    }
});

//# sourceMappingURL=app.js.map