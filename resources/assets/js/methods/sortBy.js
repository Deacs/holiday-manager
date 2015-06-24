module.exports = function(sortKey) {
    this.reverse = (sortKey == this.sortKey) ? ! this.reverse : false;
    this.sortKey = sortKey;
};
