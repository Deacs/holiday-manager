<form method="POST" action="/departments/{{ $department->slug }}/org-chart" class="dropzone" id="department-org-chart-upload">
    {{ csrf_field() }}
</form>

@section('scripts')
    <script>
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
                    // Update with new image
                });
            }
        };
    </script>
@endsection
