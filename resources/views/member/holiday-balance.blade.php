<ul class="no-bullet">
    <li><span class="round regular label">{!! $member->getAnnualHolidayAllowance() !!}</span> <small>Allowance</small></li>
    <li><span class="round secondary label">{!! $member->availableHolidayAllowance() !!}</span> <small>Available</small></li>
    <li><span class="round success label">{!! $member->activeHolidayBalance() !!}</span> <small>Active</small></li>
    <li><span class="round warning label">{!! $member->pendingHolidayBalance() !!}</span> <small>Pending</small></li>
    <li><span class="round info label">{!! $member->approvedHolidayBalance() !!}</span> <small>Approved</small></li>
    <li><span class="round alert label">{!! $member->completedHolidayBalance() !!}</span> <small>Completed</small></li>
</ul>
