@if(session()->has('flash_message'))
    <script>
        swal({
            title: "{{ session('flash_message.title') }}",
            text: "{{ session('flash_message.message') }}",
            type: "{{ session('flash_message.level') }}",
            timer: 4000,
            showConfirmButton: false
        });
    </script>
@endif

@if(session()->has('flash_message_overlay'))
    <script>
        swal({
            title: "{{ session('flash_message_overlay.title') }}",
            text: "{{ session('flash_message_overlay.message') }}",
            type: "{{ session('flash_message_overlay.level') }}",
            confirmButtonText: "{{ session('flash_message_overlay.btn_text') }}"
        });
    </script>
@endif

@if (count($errors) > 0)
    <script>
        var error_str = '{{ errorOverlay($errors) }}';

        swal({
            title: "Validation Error",
            text: error_str.replace(/\|/g, '<br/>'),
            type: "error",
            confirmButtonText: "OK",
            html: true
        });
    </script>
@endif
