module.exports = function(slug) {

    var endpoint = '/api/members';
    if (slug != '') {
        endpoint = '/api/departments/'+slug+'/team';
    }

    this.$http.get(endpoint, function(members) {
        this.members = members;
    });
}
