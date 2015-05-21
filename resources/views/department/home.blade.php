@extends('master')

@section('content')

    <div class="large-12 columns">
        <h2>{{ $department->name }}</h2>
    </div>

    <div class="large-12 columns" role="content">
        <h4>Department Lead: {{ $lead->fullName() }}</h4>

        <h5>Team Members</h5>

        @if(count($team))
            <table>
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
                        <td><strong>{!! link_to_route('member.home', $member->fullName(), [$member->slug], ['class' => 'member-link']) !!}</strong></td>
                        <td>{!! $member->email !!}</td>
                        <td>{!! $member->telephone !!}</td>
                        <td>{!! $member->getAnnualHolidayAllowance() !!}</td>
                        <td>{!! link_to('/foo', $member->pendingHolidayBalance(), ['class' => 'button tiny success']) !!}</td>
                        <td>{!! link_to('/foo', $member->approvedHolidayBalance(), ['class' => 'button tiny success']) !!}</td>
                        <td>{!! link_to('/foo', $member->availableHolidayAllowance(), ['class' => 'button tiny success']) !!}</td>
                        <td>{!! link_to('/foo', $member->onApprovedLeave() ? 'YES' : 'NO', ['class' => 'button tiny alert']) !!}</td>
                    </tr>
                @endforeach
            </table>
        @else
            <div data-alert="" class="alert-box info radius">
                No Team Members associated with {!! $department->name !!}
                <a href="#" class="close">×</a>
            </div>
        @endif
    </div>

@endsection
