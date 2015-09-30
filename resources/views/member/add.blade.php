{!! Form::open(['route' => 'member.add']) !!}

    <h4>Add New Team Member</h4>

    <div class="row panel radius">
        <div class="large-4 columns">
            <label>First Name</label>
            <input type="text" placeholder="Jamie" name="first_name">
        </div>
        <div class="large-4 columns">
            <label>Last Name</label>
            <input type="text" placeholder="Doe" name="last_name">
        </div>
        <div class="large-4 columns">
            <label>Role</label>
            <input type="text" placeholder="Analyst" name="role">
        </div>

        <div class="large-3 columns">
            <label>email address</label>
            <input type="text" placeholder="jamie.doe@crowdcube.com" name="email">
        </div>
        <div class="large-3 columns">
            <label>Telephone</label>
            <input type="text" placeholder="01392 123456" name="telephone">
        </div>
        <div class="large-3 columns">
            <label>Location</label>
            {!! Form::select('location_id', $locations, $location_id = 1) !!}

        </div>
        <div class="large-3 columns">
            <label>Department</label>
            {!! Form::select('department_id', $departments, $department_id) !!}
        </div>

        <div class="large-12 columns">
            <button class="small button" title="Add">Add</button>
        </div>
    </div>

{!! Form::close() !!}
