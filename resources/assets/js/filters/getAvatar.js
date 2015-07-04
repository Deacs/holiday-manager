module.exports = function (user, size) {
    if (typeof(size) == "undefined") {
        size = 40;
    }

    if (typeof user.avatar_path == "undefined") {
        return '/img/avatar.jpg';
    }

    return user.avatar_path.replace(/s=[0-9]?/, 's='+size);
};
