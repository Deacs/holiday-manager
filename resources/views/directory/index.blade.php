@extends('master')

@section('content')

    <div class="large-12 columns">
        <h1>Staff Directory</h1>
    </div>

    <div class="large-12 columns" role="content">
        @if (count($members))
            <table id="staff-directory">
                <tr>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Location</th>
                    <th>Role</th>
                    <th>email</th>
                    <th>Telephone</th>
                </tr>
                @foreach ($members as $member)
                    <tr>
                        <td>{!! HTML::image($member->getAvatarPath(30), $member->fullName()) !!} {!! link_to_route('member.home', $member->fullName(), ['slug' => $member->slug]) !!}</td>
                        <td>{!! link_to_route('department.home', $member->department->name, ['slug' => $member->department->slug]) !!}</td>
                        <td>{!! link_to_route('location.home', $member->department->location->name, ['slug' => $member->department->location->slug]) !!}</td>
                        <td>{!! $member->role !!}</td>
                        <td>{!! HTML::mailto($member->email, $member->email) !!}</td>
                        <td>{!! $member->telephone !!}</td>
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
