@extends('master')

@section('content')

    <div class="large-12 columns">
        <h2>{{ $department->name }}</h2>
    </div>

    <div class="large-12 columns" role="content">
        <h4>{!! HTML::image($department->lead->getAvatarThumbnailPath(30), $department->lead->fullName(), ['width' =>30]) !!} Department Lead: <a href="{{ $department->lead->url }}" id="department-lead">{{ $department->lead->fullName() }}</a></h4>
    </div>

    <div class="large-12 columns">
        <h4 class="left">Organisational Chart</h4>
        @if (Auth::user()->hasManageDepartmentPermission($department))
            <button class="button small right" v-on="click:toggleOrgChartPanel">Update Organisational Chart</button>
        @endif
    </div>

    @if (Auth::user()->hasManageDepartmentPermission($department))
        <div class="large-12 columns" v-show="showOrgChartUpdate">
            <update-org-chart department_slug="{!! $department->slug !!}" token="{!! csrf_token() !!}"></update-org-chart>
        </div>
    @endif

    <org-chart></org-chart>

    @if ($department->hasOrgChart())
        <div class="large-12 columns">
            <a href="/{!! $department->getOrgChart()->path !!}" data-lity>
                {!! HTML::image($department->getOrgChart()->thumbnail_path, $department->name.' Organisation Chart') !!}
            </a>
        </div>
    @else
        <div data-alert="" class="large-12 columns alert-box alert radius alert">
            No Organisational Chart available
        </div>
    @endif

    <div class="large-12 columns">

        <h4 class="left">Team Members</h4>

        @if (Auth::user()->hasManageDepartmentPermission($department))

            <button class="button small right" v-on="click:toggleNewMemberPanel">Add New Team Member</button>

            <div class="large-12 columns" v-show="showAddNewMember">
                @include('department.add_user')
            </div>

        @endif
    </div>

    <div class="large-12 columns">
        <member-listing dept_slug="{{ $department->slug }}" dept_name="{{ $department->name }}"></member-listing>
    </div>

@endsection
