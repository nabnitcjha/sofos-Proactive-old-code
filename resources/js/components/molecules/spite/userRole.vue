<template>
   <div class="userRole__page">
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">User</th>
                    <th scope="col" colspan="4">Role</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class="userRole__page--data">{{ '1' }}</th>
                    <th class="userRole__page--data">{{ 'User' }}</th>
                    <th class="userRole__page--data">{{ 'Admin' }}</th>
                    <th class="userRole__page--data">{{ 'Student' }}</th>
                    <th class="userRole__page--data">{{ 'Teacher' }}</th>
                    <th class="userRole__page--data">{{ 'Parent' }}</th>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            userRole: {
                user:[],
                role:[]
            }
        };
    },
    methods: {
         getUser() {

        },
        getRole() {

        }
    },
    mounted() {
        this.getUser();
        this.getRole();
    }
};
</script>

