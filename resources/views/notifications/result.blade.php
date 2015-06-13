<div data-alert class="alert-box @{{ result.level }}" v-if="holidayRequestSubmitted">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    @{{ result.message }}
</div>
