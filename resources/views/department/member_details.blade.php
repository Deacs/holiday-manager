<table id="team-holiday-status">
    <tr>
        <th>Name</th>
        <th>email</th>
        <th>Telephone</th>
        <th>Allowance</th>
        <th>Requested</th>
        <th>Approved</th>
        <th>Available</th>
        <th>On Leave</th>
    </tr>
    @foreach($team as $member)
        <tr>
            <td>{!! HTML::image($member->getAvatarPath(), $member->fullName(20)) !!} <strong>{!! link_to_route('member.home', $member->fullName(), [$member->slug], ['class' => 'member-link']) !!}</strong></td>
            <td>{!! $member->email !!}</td>
            <td>{!! $member->telephone !!}</td>
            <td>{!! $member->getAnnualHolidayAllowance() !!}</td>
            <td>{!! link_to('/foo', $member->pendingHolidayBalance(), ['class' => 'button tiny success', 'data-balance-type' => 'pending']) !!}</td>
            <td>{!! link_to('/foo', $member->approvedHolidayBalance(), ['class' => 'button tiny success', 'data-balance-type' => 'approved']) !!}</td>
            <td>{!! link_to('/foo', $member->availableHolidayAllowance(), ['class' => 'button tiny success', 'data-balance-type' => 'available']) !!}</td>
            <td>{!! link_to('/foo', $member->onApprovedLeave() ? 'YES' : 'NO', ['class' => 'button tiny alert']) !!}</td>
        </tr>
    @endforeach
</table>
