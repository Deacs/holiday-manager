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

        submitted: false
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
