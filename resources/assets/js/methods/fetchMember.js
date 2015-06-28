module.exports = function(slug) {
    this.$http.get('/api/member/'+slug, function(member) {
        this.member = member;
    });
}
