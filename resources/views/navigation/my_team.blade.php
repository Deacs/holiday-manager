<li>
    <span class="round alert label">0</span>
</li>
<li>
    {!! link_to_route('department.home', 'My Team ', ['slug' => Auth::user()->department->slug]) !!}
</li>
