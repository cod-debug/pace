<template>
    <div>
        <div class="container">
            <div class="bg-white shadow-lg p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4><i class="fa fa-users"></i> List of Employees</h4>
                    <a href="/employee/add" class="btn btn-info"><i class="fa fa-plus-circle"></i> Add Employee</a>
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
                <table class="table table-striped" v-if="!is_loading_list">
                    <thead>
                        <tr>
                            <th width="40%">Name</th>
                            <th width="40%">Office</th>
                            <th class="text-right"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, key) in list_data.data" :key="key">
                            <td>
                                {{ item.full_name }}
                            </td>
                            <td>
                                {{ item.office.name }}
                            </td>
                            <td class="text-right">
                                <button class="btn btn-sm btn-primary mx-4"><i class="fas fa-file-invoice"></i></button> 
                                <button class="btn btn-sm btn-success"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger mx-1"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-center" v-else>
                    <app-loader />
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    import Loader from '../Reusables/Loader.vue';
    export default {
        data: () => ({
            search: '',
            list_data: [],
            is_loading_list: false,
        }),
        components: {
            AppLoader: Loader,
        },
        mounted(){
            this.getList();
        },
        methods: {
            async submitSearch() {

            },

            async getList(){
                try {
                    this.is_loading_list = true;
                    let {data, status} = await this.$axios('get','/employee/list-paginated');
                    
                    if([200, 201].includes(status)){
                        this.list_data = data;
                    } else {
                        this.$swal({
                            title: 'Error',
                            text: data.message,
                            icon: 'error'
                        });
                    }
                } catch (e) {
                    this.$swal({
                        title: 'Success',
                        text: 'Something went wrong during data fetching.',
                        icon: 'error'
                    });
                }
                this.is_loading_list = false;
            },
        },
    }
</script>