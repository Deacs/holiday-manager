module.exports = function(slug) {

    console.log('SLUG: '+slug);

    var endpoint = '/api/departments';
    if (slug != '' && typeof(slug) != 'undefined') {
        endpoint = '/api/locations/'+slug+'/departments';
    }

    this.$http.get(endpoint, function(departments) {
        this.departments = departments;
    });
};
