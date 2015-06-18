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
