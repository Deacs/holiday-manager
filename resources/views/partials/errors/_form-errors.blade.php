{{--@if (count($errors) > 0)--}}
@if (!empty($errors))
    <div data-alert class="alert-box alert radius alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{!! $error !!}</li>
            @endforeach
        </ul>
    </div>
@endif
