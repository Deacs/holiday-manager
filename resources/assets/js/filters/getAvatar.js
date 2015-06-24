module.exports = function (user, size) {
    if (typeof(size) == "undefined") {
        size = 40;
    }

    return user.avatar_path.replace(/s=[0-9]?/, 's='+size);
};
