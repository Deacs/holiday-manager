@include('partials._header')
@include('navigation.header')
@include('flash::message')
@include('notifications.result')
@include('partials.errors._form-errors')

    <div class="row">

        *************

        LEVEL : @{{ flashdata.level }} >> MESSAGE : @{{ flash-data.message }}
        *************

        @yield('content')

    </div>

@include('partials._footer')


