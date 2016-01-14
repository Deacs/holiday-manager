<form method="POST" action="/departments/add">
    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
    <div class="large-12 columns">
        <div class="large-4 columns"><input type="text" id="loc_name" name="name" placeholder="Enter a name"></div>
        <div class="large-4 columns">
            <select id="location_id" name="location_id">
                <option>Please select a Location</option>
                @foreach($locations as $id => $location)
                <option value="{{ $id }}">{!! $location !!}</option>
                @endforeach
            </select>
        </div>
        <div class="large-4 columns">
            <select id="lead_id" name="lead_id">
                <option>Please select a Department Lead</option>
                @foreach($members as $id => $member)
                <option value="{{ $id }}">{!! $member !!}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="large-12 columns">
        <button class="button round success right" id="add-location">Add Department</button>
    </div>
</form>
