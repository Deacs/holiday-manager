module.exports = function(bounds) {

    var endpoint = '/api/members';

    if (typeof(bounds) !== 'undefined') {

        if (bounds.dept != '') {
            endpoint = '/api/departments/'+bounds.dept+'/team';
        }
        else if (bounds.location != '') {
            endpoint = '/api/locations/'+bounds.location+'/members';
        }
    }

    this.$http.get(endpoint, function(member_list) {

        this.members = member_list;
        this.$root._data.members = this.members;
    });
}
