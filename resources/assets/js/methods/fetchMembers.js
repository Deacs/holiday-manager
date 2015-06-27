module.exports = function(department) {

    var endpoint = '/api/members';
    if (department != '') {
        endpoint = '/api/department/'+department+'/team';
    }

    this.$http.get(endpoint, function(members) {
        this.members = members;
    });
}
