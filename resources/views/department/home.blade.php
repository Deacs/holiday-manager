@extends('master')

@section('content')

    <div class="large-12 columns">
        <h2>{{ $department->name }}</h2>
    </div>

    <div class="large-12 columns" role="content">
        <h4>{!! HTML::image($department->lead->getAvatarThumbnailPath(30), $department->lead->fullName(), ['width' =>30]) !!} Department Lead: <a href="{{ $department->lead->url }}" class="department-lead">{{ $department->lead->fullName() }}</a></h4>

        @if ($department->hasOrgChart())
            <h5>Organisational Chart</h5>
            <a href="/{!! $department->getOrgChart()->path !!}" data-lity>
                {!! HTML::image($department->getOrgChart()->thumbnail_path, $department->name.' Organisation Chart') !!}
            </a>
        @else
            <div data-alert="" class="alert-box alert radius alert">
                No Organisational Chart available
            </div>
        @endif

        @if (Auth::user()->hasManageDepartmentPermission($department))
            <h4>Update Organisational Chart</h4>

            @include('department.update_org_chart')
        @endif

        @if (Auth::user()->hasManageDepartmentPermission($department))

            <h4>Add New Team Member</h4>

            @include('notifications.result')

            @include('department.add_user')

            <hr />

        @endif

        <member-listing dept_slug="{{ $department->slug }}" dept_name="{{ $department->name }}"></member-listing>

    </div>

@endsection
