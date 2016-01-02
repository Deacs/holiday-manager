@extends('master')

@section('content')

    <div class="large-12 columns">
        <h2>{{ $department->name }}</h2>
    </div>

    <div class="large-12 columns" role="content">
        <h4>{!! HTML::image($department->lead->getAvatarThumbnailPath(30), $department->lead->fullName(), ['width' =>30]) !!} Department Lead: <a href="{{ $department->lead->url }}" class="department-lead">{{ $department->lead->fullName() }}</a></h4>
    </div>

    <div class="large-12 columns">
        <h4 class="left">Organisational Chart</h4>
        @if (Auth::user()->hasManageDepartmentPermission($department))
            <button class="button small right" v-on="click:toggleOrgChartPanel">Update Organisational Chart</button>
        @endif
    </div>

    @if (Auth::user()->hasManageDepartmentPermission($department))
        <div class="large-12 columns" v-show="showOrgChartUpdate">
            @include('department.update_org_chart')
        </div>
    @endif

    @if ($department->hasOrgChart())
        <div class="large-12 columns">
            <a href="/{!! $department->getOrgChart()->path !!}" data-lity>
                {!! HTML::image($department->getOrgChart()->thumbnail_path, $department->name.' Organisation Chart') !!}
            </a>
        </div>
    @else
        <div data-alert="" class="alert-box alert radius alert">
            No Organisational Chart available
        </div>
    @endif

    <div class="large-12 columns">
        @if (Auth::user()->hasManageDepartmentPermission($department))

            <h4>Add New Team Member</h4>

            @include('department.add_user')

        @endif
    </div>
    <div class="large-12 columns">
        <member-listing dept_slug="{{ $department->slug }}" dept_name="{{ $department->name }}"></member-listing>
    </div>

@endsection
