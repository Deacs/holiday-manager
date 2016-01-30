module.exports = function() {

    event.preventDefault();

    var member  = this.newMember;
    var    vm      = this;

    //console.log('Member: ');
    //console.log(member);
    //console.log('Members: ');
    //console.log('ROOT DATA ---- ');
    //console.log(this.$root.data);
    console.log('ROOT DATA ---- ');
    //console.log(this.$root.data);
    console.log('--- PRE CALLBACK ---');

    this.$http.post('/api/member/add', member, function(data) {

        //console.log('&&&&&&&&&&& ADD MEMBER PARENT &&&&&&&&&&&&');
        //this.$parent.$log();

        //console.log('-- Within Callback --');
        //var member = this.newMember;

        //this.$root.members.push(member);
        //this.newMember = {
        //    first_name: '',
        //    last_name: '',
        //    email: '',
        //    telephone: '',
        //    extension: '',
        //    role: '',
        //    location_id: '',
        //    department_id: ''
        //};

        //this.$dispatch('child-msg', this.msg);
        //this.msg = '';

        // Push the newly created user to the array
        //vm.$root.members.push(member);


        // Prepare the extra fields for the push to the listing
        //member.url          = data.slug;
        //member.avatar_path  = data.avatar_path;

        console.log(' --- Firing Event ---');

        // The form values need to be reset at this point

        this.$dispatch('add-member', data);

        //this.$parent.members.push(member);
        //
        //console.log('DATA ---- ');
        //console.log(data);
        //
        //console.log('MEMBER ---- ');
        //console.log(member);
        //
        //console.log('VM ----- ');
        //console.log(vm);
        //
        //console.log('MEMBERS ---- ');
        //console.log(vm.$root.members);




        swal({
            type: "success",
            title: "Success",
            text: member.first_name+" successfully added",
            timer: 2000,
            showConfirmButton: false
        });

        // WHERE IS THE MEMBERS ARRAY THAT HOLDS THE CURRENT LISTING?

        console.log('THIS ************/////////////////************');
        this.$log();
        this.members.push(member);
        this._data.members.push(member);
        console.log('THIS POST PUSH *******/////////////////*******');
        this.$log();
        console.log('ROOT ************/////////////////************');
        this.$root.$log();
        console.log('PARENT ************/////////////////************');
        this.$parent.$log();

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
                        console.log(prop + " = " + key + " >> " +obj[prop]);
                    }
                }
            }
        }
    });
}
