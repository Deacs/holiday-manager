<div class="large-12 columns">
    <div class="row panel radius">
        <h4>Request Holiday</h4>
        {!! Form::open(['route' => 'api.holiday.request']) !!}
            <div class="large-3" columns>
                <label>Start Date:
                    <input type="date" name="start_date" />
                </label>
            </div>
            <div class="large-3" columns>
                <label>End Date:
                    <input type="date" name="end_date" />
                </label>
            </div>
            <div class="large-12 columns">
                <button class="small button" title="Add">Place Request</button>
            </div>
        {!! Form::close() !!}
    </div>
</div>
