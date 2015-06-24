module.exports = function() {
    this.$http.get('/api/locations', function(locations) {
        this.locations = locations;
    });
};
