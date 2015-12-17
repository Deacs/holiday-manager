<template>
    <div class="large-2 columns">
        <img v-attr="src:member | getAvatar 200, width:200">
    </div>
    <div class="large-6 columns">
        <h2 v-text="member | nameFormat"></h2>
        <h5><i class="fi-torso large"></i> {{ member.role }}</h5>
        <h6><i class="fi-torsos-all large"></i> <a href="{{ member.department.url }}" v-text="member.department.name"></a></h6>
        <h6><i class="fi-compass"></i> <a href="{{ member.location.url }}" v-text="member.location.name"></a></h6>
        <a v-if="canEdit" href="/member/{{ member.slug }}/edit" class="button">EDIT USER</a>
    </div>
    <div class="large-4 columns">
        <h4>Contact</h4>
        <ul class="no-bullet">
            <li><i class="fi-mail large"></i> <a href="mailto:@{{ member.email }}" v-text="member.email"></a></li>
            <li><i class="fi-telephone large"></i> {{ member.telephone }}</li>
            <li><i class="fi-thumbnails large"></i> {{ member.extension }}</li>
            <li><i class="fi-social-skype large"></i> <a href="skype:{{ member.skype_name }}?call">Call</a> | <a href="skype:{{ member.skype_name }}?chat">Chat</a></li>
        </ul>
    </div>

</template>

<script>

    export default {

        props: [
            'user_slug',
            'member_slug'
        ],

        data: function() {
            return {
                member_slug:    '',
                user_slug:      '',
                member:         '',
                members:        [],
                canEdit:        false
            }
        },

        methods: {
            fetchMember:    require('../methods/fetchMember'),
            canEditMember:  require('../methods/hasEditMemberPermissions')
        },

        ready: function() {
            this.fetchMember(this.member_slug);

            this.$http.get('/api/member/'+this.member_slug+'/can-edit/'+this.user_slug, function (data, status, request) {
                console.log(data);
                this.$set('canEdit', data);
            }).error(function (data, status, request) {
                // handle error
                console.log('Some Error Occurred');
            });
        }
    }

</script>
