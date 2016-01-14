@extends('master')

@section('content')

    <h1>Add new Department</h1>

    @can('add-departments')

        @include('department.add')

    @endcan

@endsection

@section('scripts')
@endsection
