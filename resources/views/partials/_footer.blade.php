    <script src="/js/vendor/jquery.js"></script>
    <script src="/js/foundation/foundation.js"></script>
    <script src="/js/foundation/foundation.topbar.js"></script>
    <script src="js/foundation/foundation.alert.js"></script>
    <script src="js/foundation/foundation.reveal.js"></script>

    <script>
        $(document).foundation();

        $('#notificationModal').foundation('reveal', 'open');

        @yield('scripts')

    </script>

    </body>
</html>
