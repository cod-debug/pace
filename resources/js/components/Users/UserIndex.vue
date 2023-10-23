<template>
    <div>
        <div class="container">
            <div class="bg-white shadow-lg p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4><i class="fa fa-users"></i> Manage Users</h4>
                    <a href="/user/add" class="btn btn-info"><i class="fa fa-plus-circle"></i> Add User</a>
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
                
                <div v-if="!is_loading_list">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="30%">Name</th>
                                <th>Email Address</th>
                                <th>Role</th>
                                <th class="text-right"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, key) in list_data.data" :key="key">
                                <td>
                                    <i class="fa fa-circle" :class="item.status == 'active' ? 'text-success' : 'text-danger'"></i> {{ item.name }}
                                </td>
                                <td>
                                    <a :href="`mailto:${item.email}`">{{ item.email }}</a>
                                </td>
                                <td>
                                    {{ item.type }}
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
            //  
            search: '',
            page: 1,
            limit: 10,
            list_data: [],
            is_loading_list: false,

        }),
        components: {
            appLoader: Loader,
        },
        methods: {
            initApp(){
                this.getList();
            },
            submitSearch(){

            },

            async getList(){
                try {
                    this.is_loading_list = true;
                    let {data, status} = await this.$axios('get',`/api/user/get-list?search=${this.search}&page=${this.page}&limit=${this.limit}`);
                    
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

        mounted(){
            this.initApp();
        },
    }
</script>