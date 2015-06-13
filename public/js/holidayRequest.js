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

        onSubmitForm: function(e) {

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
