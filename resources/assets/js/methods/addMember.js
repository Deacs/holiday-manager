module.exports = function(e) {

    e.preventDefault();

    var member = this.newMember;
    // Need to resolve the department name from the ID

    this.members.push(member);
    this.newMember = {
        first_name: '',
        last_name: '',
        slug: '',
        role: '',
        email: '',
        telephone: '',
        extension: '',
        skype_name: '',
        department_id: '',
        location_id: '',
        created_at: Moment()
    };

    this.$http.post('/api/member/add', member);

    this.submitted = true;
}
