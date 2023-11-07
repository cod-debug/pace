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
                <div v-if="!is_loading_list">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="30%">Name</th>
                                <th width="30%">Office</th>
                                <th width="20%">Employment Status</th>
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
                                <td>
                                    {{ item.employment_status }}
                                </td>
                                <td class="text-right">
                                    <div class="text-right" v-if="item.id !== selected_id">
                                        <a :href="`/employee/record/${item.id}`" :class="`btn btn-sm btn-primary ${auth_data.type === 'admin' ? 'mx-4': ''}`"><i class="fas fa-file-invoice"></i></a> 
                                        <a class="btn btn-sm btn-success" v-if="auth_data.type === 'admin'" :href="`/employee/edit/${item.id}`"><i class="fa fa-edit"></i></a>
                                        <button class="btn btn-sm btn-danger mx-1" v-if="auth_data.type === 'admin'"  @click="confirmDelete(item)" ><i class="fa fa-trash"></i></button>
                                    </div>
                                    <div v-if="show_confirm_delete && item.id === selected_id">
                                        <label class="mb-2"><input type="password" v-model="password" class="form-control" placeholder="Confirm Password"/></label>
                                        <br />
                                        <button class="btn btn-outline-danger btn-sm" @click="checkAuth(item.id)" title="Confirm delete?"><i class="fa fa-check-circle"></i> Yes</button>
                                        <button class="btn btn-outline-secondary btn-sm mx-1" @click="cancelDelete" title="Cancel delete?"><i class="fa fa-times-circle"></i> No</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            <small>Showing {{ list_data.from }} to {{ list_data.to }} of {{ list_data.total }}</small>
                        </div>
                        <vue-awesome-paginate v-model="page"
                            :total-items="list_data.total"
                            :items-per-page="limit"
                            :max-pages-shown="5"
                            :current-page="1"
                            :on-click="getList"></vue-awesome-paginate>
                    </div>
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
        props: {
            auth: String,
        },
        data: () => ({
            search: '',
            page: 1,
            limit: 10,
            list_data: [],
            is_loading_list: false,
            selected_id: null,
            password: '',
            show_confirm_delete: false,
        }),
        components: {
            AppLoader: Loader,
        },
        computed:{
            auth_data(){
                return JSON.parse(this.auth);
            }
        },
        mounted(){
            this.getList();
            this.auth_user = JSON.parse(this.auth);
        },
        methods: {
            async submitSearch() {
                this.page = 1;
                this.getList();
            },

            async checkAuth(id){
                let payload = {
                    email: this.auth_user.email,
                    password: this.password,
                }

                let fd = this.payloadToFormdata(payload);
                
                let res = await this.$axios('post', `/api/auth/check`, fd);
                if([200, 201].includes(res.status)){
                    this.trash(id);
                } else {
                    this.$swal({
                        title: 'Error',
                        text: 'Invalid password',
                        icon: 'error'
                    });
                }
            },
            async trash(id){
                try {
                    let {data, status} = await this.$axios('get', `/api/employee/trash/${id}`);
                    
                    if([200, 201].includes(status)){
                        this.$swal({
                            title: 'Success',
                            text: data.message,
                            icon: 'success'
                        });
                        this.password = "";
                        this.getList();
                    } else {
                        this.$swal({
                            title: 'Success',
                            text: data.message,
                            icon: 'error'
                        });
                    }
                } catch (e) {
                    console.log(e);
                    this.$swal({
                        title: 'Error',
                        text: 'Something went wrong during submission. Kindly contact the developer.',
                        icon: 'error'
                    });
                }
            },
            async getList(){
                try {
                    this.is_loading_list = true;
                    let {data, status} = await this.$axios('get',`/employee/list-paginated?search=${this.search}&page=${this.page}&limit=${this.limit}`);
                    
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
            confirmDelete(item){
                this.selected_id = item.id;
                this.password = "";
                this.show_confirm_delete = true;
            },
            cancelDelete(){
                this.selected_id = null;
                this.show_confirm_delete = false;
            },
        },
    }
</script>