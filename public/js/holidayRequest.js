Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

new Vue({

    el: '#app',

    data: {
        submitted: false,

        defaultDate: ''
    },

    methods: {

        onSubmitForm: function(e) {

            e.preventDefault();

            var holidayRequest = this.newHolidayRequest;

            this.newHolidayRequest = {
                start_date: this.defaultDate,
                end_date: this.defaultDate
            };

            this.$http.post('/api/holiday/request', holidayRequest);

            this.submitted = true;
        }
    }
});
