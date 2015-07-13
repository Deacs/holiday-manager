@if (Auth::user()->leadDepartment())
    @include('navigation.my_team')
@endif
<li class="divider hide-for-small"></li>
<li class="has-dropdown hover"><a>Teams</a>
    <ul class="dropdown"><li class="title back js-generated"><h5><a href="javascript:void(0)">Back</a></h5></li>
        <li><label>Select a Location</label></li>
        @foreach ($locations as $location)
            <li class="has-dropdown hover">{!! link_to_route('location.home', $location->name, ['slug' => $location->slug]) !!}</a>
                <ul class="dropdown"><li class="title back js-generated"><h5><a href="javascript:void(0)">Back</a></h5></li>
                    <li><label>Select a Department</label></li>
                    @foreach ($location->departments as $department)
                        <li>{!! link_to_route('department.home', $department->name, ['slug' => $department->slug]) !!}</li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
</li>
<li class="divider"></li>
<li>{!! link_to_route('home', 'Directory') !!}</li>
<li class="divider"></li>
<li class="has-dropdown hover"><a>{!! Auth::user()->fullName() !!}</a>
    <ul class="dropdown"><li class="title back js-generated"><h5><a href="javascript:void(0)">Back</a></h5></li>
        <li>{!! link_to_route('member.home', 'Profile', ['slug' => Auth::user()->slug]) !!}</li>
        <li>{!! link_to_route('logout', 'Logout') !!}</li>
    </ul>
</li>
<li>{!! HTML::image(Auth::user()->getAvatarPath(45), Auth::user()->fullName()) !!}</li>
