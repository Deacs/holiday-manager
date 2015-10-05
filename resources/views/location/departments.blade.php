<table>
    <tr>
        <th>Name</th><th>Lead</th><th>email</th>
    </tr>
    @foreach ($departments as $department)
        <tr>
            <td>{!! link_to_route('department.home', $department->name, ['slug' => $department->slug]) !!}</td>
            <td>{!! HTML::image($department->lead->getAvatarPath(20), $department->lead->fullName()) !!} {!! link_to_route('member.home', $department->lead->fullName(), [$department->lead->slug], ['class' => 'member-link']) !!}</td>
            <td>{{ $department->lead->email }}</td>
        </tr>
    @endforeach
</table>
