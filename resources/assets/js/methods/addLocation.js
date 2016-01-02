module.exports = function(e) {

    e.preventDefault();

    var location = this.newLocation;

    this.$http.post('/api/locations/add', location, function(data) {

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

    });
}
