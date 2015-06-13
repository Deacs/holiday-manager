@section('meta-headers')
    <meta id="token" name="token=" value="{!! csrf_token() !!}">
@endsection

<div class="large-12 columns" id="requestHolidayForm">
    <div class="large-12 columns">
        <div class="alert alert-success" v-if="submitted">
            Holiday Request Successfully Received
        </div>
    </div>
    <div class="row panel radius">
        <h4>Request Holiday</h4>
        {!! Form::open(['route' => 'api.holiday.request', 'v-on' => 'submit: onSubmitForm']) !!}
            <div class="large-3 columns">
                <label>Start Date:
                    <input type="date" name="start_date" value="{!! $restrictions['start'] !!}" min="{!! $restrictions['start'] !!}" max="{!! $restrictions['end'] !!}" v-model="newHolidayRequest.start_date">
                </label>
            </div>
            <div class="large-3 columns">
                <label>End Date:
                    <input type="date" name="end_date" value="{!! $restrictions['start'] !!}" value="{!! $restrictions['start'] !!}" min="{!! $restrictions['start'] !!}" max="{!! $restrictions['end'] !!}" v-model="newHolidayRequest.end_date">
                </label>
            </div>
            <div class="large-12 columns">
                <button class="small button" title="Add">Place Request</button>
            </div>
        {!! Form::close() !!}
    </div>
</div>

@section('scripts')

    <script src="/js/holidayRequest.js"></script>

@endsection
