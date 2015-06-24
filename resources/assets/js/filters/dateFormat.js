module.exports = function (ymd, type) {

    if (type == 'time') {
        return Moment(ymd).format("DD/MM/YYYY H:mm");
    }

    return Moment(ymd).format("DD/MM/YYYY");
}
