module.exports = function(user) {

    if (user != null) {
        return user.first_name+' '+user.last_name;
    }

    return 'Unknown User';

}
