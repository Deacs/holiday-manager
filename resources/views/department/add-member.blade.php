{!! Form::open() !!}
<fieldset>
    <legend>Add New Department Member</legend>

    <div class="row">
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

        <div class="large-4 columns">
            <label>email address</label>
            <input type="text" placeholder="jamie.doe@crowdcube.com" name="email">
        </div>
        <div class="large-4 columns">
            <label>Telephone</label>
            <input type="text" placeholder="01392 123456" name="telephone">
        </div>
        <div class="large-4 columns">
            <label>Location</label>
            <input type="text" placeholder="Exeter" name="location">
        </div>
    </div>

    <div class="row">
        <div class="large-12 columns">
            <button class="small button" title="Add">Add</button>
        </div>
    </div>

</fieldset>
{!! Form::close() !!}
