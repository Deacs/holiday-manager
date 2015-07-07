module.exports = function(e) {

    e.preventDefault();

    var member = this.newMember;

    this.$http.post('/api/member/add', member, function(data) {
        // Prepare the extra fields for the push to the listing
        member.url          = data.slug;
        member.avatar_path  = data.avatar_path;

        // Push the newly created user to the array
        this.members.push(member);

        this.flashData      = {
            level:      'success',
            message:    'User successfully added'
        };

    }).error(function (data, status) {

        console.log(data.first_name);
        console.log(data.last_name);

        // Each field that has failed validation needs
        // to highlight the relevant input field

        this.flashData = {
            level:      'alert',
            message:    'User could not be added'
        };

    });

    this.displayFlash = true;
}
