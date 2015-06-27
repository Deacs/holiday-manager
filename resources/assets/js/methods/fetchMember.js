module.exports = function(slug) {

    this.$http.get('/api/member/'+slug, function(member) {

        console.log(member);
        this.member = member;
    });
}
