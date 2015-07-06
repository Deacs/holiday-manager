module.exports = function(e) {

    e.preventDefault();

    var member = this.newMember

    //$.post(
    //    '/api/member/add',
    //    member);

    //console.log($);

    //member.slug = makeSlug;
    //
    //console.log('+++++ '+member.slug);

    this.$http.post('/api/member/add', member);

    this.members.push(member);
}
