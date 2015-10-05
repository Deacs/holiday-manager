module.exports = function(bounds) {

    var endpoint = '/api/members';

    if (typeof(bounds) !== 'undefined') {

        console.log('Have Member Bounds');
        console.log(bounds);

        if (bounds.dept != '') {
            endpoint = '/api/departments/'+bounds.dept+'/team';
        }
        else if (bounds.location != '') {
            endpoint = '/api/locations/'+bounds.location+'/members';
        }
    }
    else {
        console.log('No Member Bounds');
    }

    console.log('Member Endpoint : '+endpoint);

    this.$http.get(endpoint, function(members) {
        this.members = members;
    });
}
