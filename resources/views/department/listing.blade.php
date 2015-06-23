<table>
    <tr>
        <th>Name</th><th>Lead</th>
    </tr>
    <tr v-repeat="departments">
        <td><a href="@{{ url }}" v-text="name"></a></td>
        <td><a href="@{{ lead.url }}" v-text="lead | nameFormat"></a></td>
    </tr>
</table>
