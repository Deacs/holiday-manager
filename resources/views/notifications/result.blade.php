<div data-alert class="alert-box @{{ flashData.level }}" v-if="displayFlash">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    @{{ flashData.message }}
</div>
