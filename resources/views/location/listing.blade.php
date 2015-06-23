<table>
    <tr>
        <th>Name</th><th>Address</th><th>Telephone</th>
    </tr>
    <tr v-repeat="locations">
        <td><a href="@{{ url }}" v-text="name"></a></td>
        <td>@{{ address }}</td>
        <td>@{{ telephone }}</td>
    </tr>
</table>
