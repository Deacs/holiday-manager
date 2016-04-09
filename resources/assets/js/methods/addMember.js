module.exports = function() {

    event.preventDefault();

    var member  = this.newMember;
    var vm      = this;

    this.$http.post('/api/member/add', member, function(data) {

        this.members.push(member);

        swal({
            type: "success",
            title: "Success",
            text: member.first_name+" successfully added",
            timer: 2000,
            showConfirmButton: false
        });

    }).error(function (data, status) {

        // Each field that has failed validation needs
        // to highlight the relevant input field
        for (var key in data) {
            if (data.hasOwnProperty(key)) {
                var obj = data[key];
                for (var prop in obj) {
                    // important check that this is objects own property
                    // not from prototype prop inherited

                    // Call SweetAlert to handle the error report
                    if(obj.hasOwnProperty(prop)){

                        swal({
                            type: "error",
                            title: "Error",
                            text: "New user could not be added :: "+prop + " = " + key + " >> " +obj[prop],
                            timer: 2000,
                            showConfirmButton: false
                        });
                        console.log(prop + " = " + key + " >> " +obj[prop]);
                    }
                }
            }
        }
    });
}
