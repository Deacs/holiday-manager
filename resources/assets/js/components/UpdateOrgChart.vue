<template>

   <form method="POST" action="/departments/{{ department_slug }}/org-chart" class="dropzone" id="department-org-chart-upload">
        <input type="hidden" name="_token" value="{{ token }}">
   </form>

</template>

<script>

    export default {

        props: ['department_slug', 'token'],

        data: function() {
            return {}
        },
        methods: {},
        filters: {},

        ready: function() {
            // Make the Vue instance available within the Dropzone instance
            var vm = this;

            Dropzone.options.departmentOrgChartUpload = {
                paramName: "file",
                maxFilesize: 2, // MB
                maxFiles: 1, // Do not allow multiple uploads
                dictDefaultMessage: 'Drag your new organisation chart here',

                init: function() {
                    this.on("success", function(file) {
                        swal({
                            type: "success",
                            title: "Success",
                            text: "Organisational Chart successfully updated",
                            timer: 2000,
                            showConfirmButton: false
                        });
                        // Clear out the file list
                        this.removeAllFiles( true );
                        // Close the upload panel
                        vm.$root.showOrgChartUpdate = false;
                        // Update with new image
                        // TODO
                    });
                }
            };


        }
    }

</script>
