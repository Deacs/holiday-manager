Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

new Vue({

    el: '#requestHolidayForm',

    data: {
        //newHolidayRequest: {
        //    start_date: '',
        //    end_date: '',
        //    user_id: ''
        //},

        submitted: false
    },

    methods: {

        onSubmitForm: function(e) {

            e.preventDefault();

            var holidayRequest = this.newHolidayRequest;

            //this.newHolidayRequest = {
            //    start_date: '',
            //    end_date: ''
            //};

            console.log('Loaded the object');

            this.$http.post('/api/holiday/request', holidayRequest);

            this.submitted = true;
        }
    }
});
