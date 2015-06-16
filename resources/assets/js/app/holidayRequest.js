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
