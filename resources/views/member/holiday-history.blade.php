<h4>Holiday History</h4>

<table width="100%" v-if="haveHistory">
    <thead>
    <tr>
        <th>Status</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Day Count</th>
        <th>Requested</th>
        <th>Approved By</th>
        <th>Declined By</th>
    </tr>
    </thead>
    <tbody>
        <tr v-repeat="holidayRequests | orderBy start_date">
            <td>@{{ status_id }} [@{{ id }}]</td>
            <td>@{{ start_date }}</td>
            <td>@{{ end_date }}</td>
            <td></td>
            <td>@{{ created_at }}</td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>

<div data-alert="" class="alert-box info radius" v-if="!haveHistory">
    No holiday history
</div>
