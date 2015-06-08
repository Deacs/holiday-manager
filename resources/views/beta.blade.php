@extends('master')

@section('meta-headers')
<meta id="token" name="token=" value="{!! csrf_token() !!}">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <h1>Beta</h1>

            <div id="members">

                <div class="large-12 columns">
                    <div class="alert alert-success" v-if="submitted">
                        Member Successfully Added
                    </div>
                </div>

                <form method="POST" v-on="submit: onSubmitForm">

                    <div class="large-4 columns">
                        <label for="first_name">First Name <span class="reqd" v-if=" ! newMember.first_name">*</span></label>
                        <input type="text" placeholder="Jamie" name="first_name" v-model="newMember.first_name">
                    </div>
                    <div class="large-4 columns">
                        <label for="last_name">Last Name <span class="reqd" v-if=" ! newMember.last_name">*</span></label>
                        <input type="text" placeholder="Doe" name="last_name" v-model="newMember.last_name">
                    </div>
                    <div class="large-4 columns">
                        <label for="role">Role <span class="reqd" v-if=" ! newMember.role">*</span></label>
                        <input type="text" placeholder="Analyst" name="role" v-model="newMember.role">
                    </div>

                    <div class="large-3 columns">
                        <label for="email">email address <span class="reqd" v-if=" ! newMember.email">*</span></label>
                        <input type="text" placeholder="jamie.doe@crowdcube.com" name="email" v-model="newMember.email">
                    </div>
                    <div class="large-3 columns">
                        <label for="telephone">Telephone</label>
                        <input type="text" placeholder="01392 123456" name="telephone" v-model="newMember.telephone">
                    </div>
                    <div class="large-3 columns">
                        <label for="location_id">Location <span class="reqd" v-if=" ! newMember.location_id">*</span></label>
                        {!! Form::select('location_id', $locations, $location_id = 1, ['v-model' => 'newMember.location_id']) !!}

                    </div>
                    <div class="large-3 columns">
                        <label for="department_id">Department <span class="reqd" v-if=" ! newMember.department_id">*</span></label>
                        {!! Form::select('department_id', $departments, $department_id = 1, ['v-model' => 'newMember.department_id']) !!}
                    </div>

                    <div class="large-12 columns">
                        <button class="small button" title="Add" v-attr="disabled: errors">Add</button>
                    </div>

                </form>

                <hr />

                <div class="large-12 columns">

                    <article v-repeat="members">
                        <h4>@{{ first_name }} @{{ last_name }}</h4>
                        @{{ email }}
                    </article>

                </div>

            </div>

        </div>
    </div>
@endsection

@section('scripts')

    <script src="/js/app.js"></script>

@endsection
