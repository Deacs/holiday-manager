module.exports = function(e) {

    e.preventDefault();

    console.log('Adding Member');

    var member = this.newMember;

    this.$http.post('/api/member/add', member, function(data) {
        // Prepare the extra fields for the push to the listing
        member.url          = data.slug;
        member.avatar_path  = data.avatar_path;

        // Push the newly created user to the array
        this.members.push(member);

        this.flashdata      = {
            level:      'success',
            message:    'User successfully added'
        };

    }).error(function (data, status) {

        // Each field that has failed validation needs
        // to highlight the relevant input field
        for (var key in data) {
            if (data.hasOwnProperty(key)) {
                var obj = data[key];
                for (var prop in obj) {
                    // important check that this is objects own property
                    // not from prototype prop inherited
                    if(obj.hasOwnProperty(prop)){
                        console.log(prop + " = " + key + " >> " +obj[prop]);
                    }
                }
            }
        }

    });
}
