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

            console.log('Org Chart Component Ready');

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
                        // -- TODO
                        // Close the upload panel

                        this.showOrgChartUpdate = false;

                        // Update with new image
                    });
                }
            };
        }
    }

</script>
