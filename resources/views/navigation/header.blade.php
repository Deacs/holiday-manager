<div class="contain-to-grid sticky">
    <nav class="top-bar" data-topbar="" role="navigation" data-options="sticky_on: large">
        <!-- Title -->
        <ul class="title-area">
            <li class="name"><h1><a href="#">Holiday Manager</a></h1></li>

            <!-- Mobile Menu Toggle -->
            <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
        </ul>

        <!-- Top Bar Section -->
        <section class="top-bar-section">
            <ul class="right">
                <li class="divider"></li>
                <li><a href="#">Your Holiday</a></li>
                <li class="divider"></li>
                <li><a href="#">Manage Requests</a></li>
                <li class="divider hide-for-small"></li>
                <li class="has-dropdown hover"><a>Department</a>
                    <ul class="dropdown"><li class="title back js-generated"><h5><a href="javascript:void(0)">Back</a></h5></li>
                        <li><label>Dropdown Level 1 Label</label></li>
                        @foreach ($locations as $location)
                            <li class="has-dropdown hover"><a>{{ $location->name }}</a>
                                <ul class="dropdown"><li class="title back js-generated"><h5><a href="javascript:void(0)">Back</a></h5></li>
                                    @foreach ($location->departments as $department)
                                        <li><a href="/department/{{ $department->id }}">{{ $department->name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </section>
    </nav>
</div>
