@include('partials/_header')
@include('navigation/header')
@include('flash::message')
@include('partials.errors._form-errors')

    <div class="row" id="app">

        @yield('content')

    </div>

@include('partials/_footer')


