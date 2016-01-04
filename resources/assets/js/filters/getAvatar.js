module.exports = function (user, size) {
    if (typeof(size) == "undefined") {
        size = 40;
    }

    if (user != null) {

        if (typeof user.avatar_thumbnail_path == "undefined") {
            return '/img/avatar.jpg';
        }

        return user.avatar_thumbnail_path.replace(/s=[0-9]?/, 's='+size);
    }

    return '/img/avatar.jpg';

};
