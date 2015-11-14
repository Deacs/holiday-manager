@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/dropzone.css" rel="stylesheet">
@endsection

<form method="POST" action="/departments/{{ $department->slug }}/org-chart" class="dropzone">
    {{ csrf_field() }}
</form>

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/dropzone.js"></script>
@endsection
