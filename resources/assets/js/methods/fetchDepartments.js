module.exports = function() {
    this.$http.get('/api/departments', function(departments) {
        this.departments = departments;
    });
};
