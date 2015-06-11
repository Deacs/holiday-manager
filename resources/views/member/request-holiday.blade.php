<div class="large-12 columns">
    <h4>Request Holiday</h4>
    {!! Form::open() !!}
        <div class="large-6" columns>
            <label>Start Date:</label>
            <input type="date" name="start_date" />
        </div>
        <div class="large-6" columns>
            <label>End Date:</label>
        </div>
        <div class="large-12 columns">
            <button class="small button" title="Add">Place Request</button>
        </div>
    {!! Form::close() !!}
</div>

