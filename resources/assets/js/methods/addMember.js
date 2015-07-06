module.exports = function(e) {

    e.preventDefault();

    var member = this.newMember

    this.$http.post('/api/member/add', member, function(data) {
        member.url          = data.slug;
        member.avatar_path  = data.avatar_path;

        this.members.push(member);
    });
}
