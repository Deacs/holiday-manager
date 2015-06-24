module.exports = function() {
    this.$http.get('/api/members', function(members) {
        this.members = members;
    });
}
