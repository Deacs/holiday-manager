module.exports = function(slug) {

    var endpoint = '/api/members';
    if (slug != '') {
        endpoint = '/api/department/'+slug+'/team';
    }

    this.$http.get(endpoint, function(members) {
        this.members = members;
    });
}
