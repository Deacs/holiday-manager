module.exports = function(slug) {
    console.log('Calling with SLUG : '+slug);
    this.$http.get('/api/department/'+slug, function(department) {
        this.department = department;
    });
};
