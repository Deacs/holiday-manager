@extends('master')

@section('content')
    <div class="row">
        <h4>Upload File to parse as Search Index</h4>
    </div>

    <div class="row">
        <div class="large-2 columns left">
            <form method="POST" action="/parse-index" id="search-index-upload" class="dropzone" style="height:40px;">
                {{ csrf_field() }}
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        Dropzone.options.searchIndexUpload = {
            paramName: "file",
            maxFilesize: 5, // MB
            maxFiles: 1, // Do not allow multiple uploads
            dictDefaultMessage: 'Drag your new search index here',

            init: function() {
                this.on("success", function(file) {
                    swal({
                        type: "success",
                        title: "Success",
                        text: "Search Index successfully updated",
                        timer: 2000,
                        showConfirmButton: false
                    });
                });
            }
        };
    </script>
@endsection
