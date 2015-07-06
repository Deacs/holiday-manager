module.exports = function() {

    e.preventDefault();

    var member = this.newMember;

    console.log(member.first_name);
    console.log(member.last_name);

    //this.members.push(member);

    console.log(member.first_name+'-'+member.last_name);

    return '******** '+member.first_name+'-'+member.last_name+' ********';

    //this.$http.post('/api/member/add', member);
}
