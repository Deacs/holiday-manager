<h4>Holiday History</h4>

Allowance <span class="round regular label">{!! $member->getAnnualHolidayAllowance() !!}</span>
Available <span class="round secondary label">{!! $member->availableHolidayAllowance() !!}</span>
Active <span class="round success label">{!! $member->activeHolidayBalance() !!}</span>
Pending <span class="round warning label">{!! $member->pendingHolidayBalance() !!}</span>
Approved <span class="round info label">{!! $member->approvedHolidayBalance() !!}</span>
Completed <span class="round alert label">{!! $member->completedHolidayBalance() !!}</span>

<hr />
{!! $history !!}
