<template>
    <div>
        <div class="container">
            <div class="bg-white shadow-lg p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4><i class="fa fa-users"></i> Manage Users</h4>
                    <a href="/user/add" class="btn btn-info"><i class="fa fa-plus-circle"></i> Add User</a>
                </div>
                <div class="border border-muted my-2"></div>
                <div class="mt-4">

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: () => ({
            list_data: [],
        }),

        methods: {
        },
    }
</script>