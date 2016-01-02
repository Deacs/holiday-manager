    <script src="/js/vendor.js"></script>
    <script src="/js/app.js"></script>

    @include('partials.notifications.flash')

    @yield('scripts')

    <script>
        $(document).foundation();

        $('#notificationModal').foundation('reveal', 'open');

    </script>

    </body>
</html>
