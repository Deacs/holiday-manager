@include('partials/_header')
@include('navigation/header')

    <div class="row">

        @if (Session::has('message'))
            {!! Session::get('message') !!}
        @endif

        @yield('content')

    </div>

@include('partials/_footer')


