<div class="contain-to-grid sticky">
    <nav class="top-bar" data-topbar="" role="navigation" data-options="sticky_on: large">
        <!-- Title -->
        <ul class="title-area">
            <li class="name"><h1>{!! link_to_route('home', 'Holiday Planner') !!}</h1></li>

            <!-- Mobile Menu Toggle -->
            <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
        </ul>

        <!-- Top Bar Section -->
        <section class="top-bar-section">
            <ul class="right">
                @include(Auth::user() ? 'navigation.authenticated' : 'navigation.guest')
            </ul>
        </section>
    </nav>
</div>
