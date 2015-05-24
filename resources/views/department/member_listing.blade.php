<ul>
    @foreach($team as $member)
        <li>{!! link_to_route('member.home', $member->fullName(), [$member->slug], ['class' => 'member-link']) !!}</li>
    @endforeach
</ul>
