module.exports = function(bounds) {

    var endpoint = '/api/departments';

    if (typeof(bounds) !== 'undefined') {
        if (bounds.location != '') {
            endpoint = '/api/locations/'+bounds.location+'/departments';
        }
    }

    this.$http.get(endpoint, function(departments) {
        this.departments = departments;
    });
}
