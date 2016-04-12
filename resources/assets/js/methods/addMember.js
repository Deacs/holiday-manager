module.exports = function() {

    event.preventDefault();

    var member = this.newMember;

    this.$http.post('/api/member/add', member, function(data) {

        this.members.push(member);

        // Check SweetAlert for callback options
        swal({
            type: "success",
            title: "Success",
            text: member.first_name+" successfully added",
            timer: 2000,
            showConfirmButton: false
        });

        // Clear form inputs
        // TODO
        //member.first_name   = '';
        //member.last_name    = '';
        //member.role         = '';
        //member.email        = '';
        //member.skype_name   = '';
        //member.telephone    = '';
        //member.extension    = '';
        //member.location_id  = '';

    }).error(function (data, status) {

        var error_msg   = '',
            error_items = [];

        for (var key in data) {
            if (data.hasOwnProperty(key)) {
                var obj = data[key];
                for (var prop in obj) {
                    // Important check that this is objects own property
                    // not from prototype prop inherited
                    if(obj.hasOwnProperty(prop)){
                        error_items.push(obj[prop]);
                        console.log(prop + " = " + key + " >> " +obj[prop]);

                        // Each field that has failed validation needs
                        // to highlight the relevant input field
                        var ele = document.getElementById(key);

                        if (ele != null) {
                            ele.className = 'form-error';
                        }
                    }
                }
            }
        }

        error_msg = "The following error"+ (error_items.length > 1 ? 's' : '') +" prevented the user being added:\n\n"+error_items.join("\n"),

        // Init SweetAlert to handle the error report
        swal({
            type: "error",
            title: "Error",
            text: error_msg,
            timer: 4000,
            showConfirmButton: false
        });
    });
}
