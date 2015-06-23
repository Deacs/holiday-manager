<table>
    <tr>
        <th>Name</th><th>Role</th><th>Email</th><th>Telephone</th><th>Extension</th>
    </tr>
    <tr v-repeat="member: members">
        <td><img src="@{{ member | getAvatar }}"> <a href="@{{ member.url }}" v-text="member | nameFormat"></a></td>
        <td v-text="member.role"></td>
        <td><a href="mailto:@{{ email }}" v-text="member.email"></a></td>
        <td v-text="member.telephone"></td>
        <td></td>
    </tr>
</table>
