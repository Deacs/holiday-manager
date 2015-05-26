@include('partials/_header')
@include('navigation/header')
@include('flash::message')

    <div class="row">

        @yield('content')

    </div>

@include('partials/_footer')


