<template>
    <div>
        <div class="container">
            <div class="bg-white shadow-lg p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4><i class="fa fa-users"></i> List of Employees</h4>
                    <a href="/employee/add" class="btn btn-outline-primary"><i class="fa fa-plus-circle"></i> Add Employee</a>
                </div>
                <div class="border border-muted my-2"></div>
                <form @submit.prevent="submitSearch" class="mt-4 mb-2">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- RIGHT SIDE OF SEARCH BAR -->
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Search" v-model="search" aria-label="Search" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" style="border-radius: 0;" type="submit"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Office</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="3" class="text-muted">No data found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        data: () => ({
            search: '',
        }),
        methods: {
            async submitSearch() {

            },
        },
    }
</script>