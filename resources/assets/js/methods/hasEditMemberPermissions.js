module.exports = function(user_slug, member_slug, cb) {

    // return the response from the endpoint to determine the permissions
    // of this user in relation to editing the current member

    var permitted;

    if (! permitted) {

        this.$http.get('/api/member/'+user_slug+'/can-edit/'+member_slug, function(result) {

            permitted = result;
            cb(result);

            return result;
        });

    } else {

        cb(permitted);

    }

    return false;
}
