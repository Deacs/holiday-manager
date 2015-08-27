module.exports = function(e) {

    e.preventDefault();

    var location = this.newLocation;

    console.log(location);

    this.$http.post('/api/location/add', location, function(data) {

        console.log('*********************');
        console.log(location);
        console.log(data);
        console.log('*********************');

        this.flashdata = {
            level:      'success',
            message:    'Location successfully added'
        };

        // Close the modal

        // Push the newly created location to the array

    }).error(function (data, status) {

        // Each field that has failed validation needs
        // to highlight the relevant input field
        for (var key in data) {
            if (data.hasOwnProperty(key)) {
                var obj = data[key];
                for (var prop in obj) {
                    // important check that this is objects own property
                    // not from prototype prop inherited
                    if(obj.hasOwnProperty(prop)){
                        console.log(prop + " = " + key + " >> " +obj[prop]);
                    }
                }
            }
        }

        this.flashdata = {
            level:      'alert',
            message:    'Location could not be added'
        };

        //this.updateFlash(true, 'success', 'from function');

    });

    this.displayflash = true;
}
