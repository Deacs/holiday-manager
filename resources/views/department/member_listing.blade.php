<ul class="no-bullet">
    @foreach($team as $member)
        <li>{!! HTML::image($member->getAvatarPath(20), $member->fullName()) !!} {!! link_to_route('member.home', $member->fullName(), [$member->slug], ['class' => 'member-link']) !!}</li>
    @endforeach
</ul>
