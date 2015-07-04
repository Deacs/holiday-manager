module.exports = function(e) {

    var Moment  = require('moment');

    e.preventDefault();

    var member = this.newMember;
    // Need to resolve the department name from the ID

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
        avatar_path: '/img/avatar.jpg',
        department_name: 'OUTER SPACE',
        created_at: Moment()
    };

    this.members.push(member);

    this.$http.post('/api/member/add', member);
}
