module.exports = function(slug) {
    this.$http.get('/api/departments/'+slug, function(department) {
        this.department = department;
    });
};
