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
                                <td class="text-right" width="30%">
                                    <button class="btn btn-primary btn-sm btn-secondary" v-if="(item.id != auth_user.id) && (item.id != selected_user.id)" @click="confirmPassword(item)">
                                        Change Password 
                                    </button>
                                    <button class="btn btn-primary btn-sm btn-success" @click="confirmChangePassword" v-if="(item.id == selected_user.id)">
                                        <i class="fa fa-unlock"></i> Emergency Change Password
                                    </button>
                                </td>
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
    import Swal from 'sweetalert2';
    export default {
        props:[
            'auth'
        ],
        data: () => ({
            //  
            search: '',
            page: 1,
            limit: 10,
            list_data: [],
            is_loading_list: false,

            auth_user: null,
            show_change_password_btn: false,

            selected_user: {},
        }),
        components: {
            appLoader: Loader,
        },
        methods: {
            initApp(){
                this.getList();
                this.auth_user = JSON.parse(this.auth);
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
            confirmPassword(item){
                
                Swal.fire({
                    title: "Confirm Password",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'Cancel',
                    cancelButtonColor: 'brown',
                    html: `
                    <div class='form-group' style='text-align: left;'>
                        <label>Password</label>
                        <input type='password' class='form-control' id='confirmPassword' />
                    </div>
                    `
                }).then((e) => {
                    if(e.isConfirmed) {
                        this.checkAuth(item);
                    }
                });
            },

            async checkAuth(item){
                let password = document.getElementById('confirmPassword').value;
                let payload = {
                    email: this.auth_user.email,
                    password: password,
                }

                let fd = this.payloadToFormdata(payload);
                
                let res = await this.$axios('post', `/api/auth/check`, fd);
                if([200, 201].includes(res.status)){
                    this.show_change_password_btn = true;
                    this.selected_user = item;
                } else {
                    this.show_change_password_btn = false;
                    this.$swal({
                        title: 'Error',
                        text: 'Invalid password',
                        icon: 'error'
                    });
                }
            },

            async confirmChangePassword(){
                let vm = this;

                Swal.fire({
                    title: "Confirm Password",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'Cancel',
                    cancelButtonColor: 'brown',
                    html: `
                    <div class='form-group' style='text-align: left;'>
                        <label>Email</label>
                        <input type='email' readonly value='${this.selected_user.email}' class='form-control' id='confirmPassword' />
                    </div>
                    <br />
                    <div class='form-group' style='text-align: left;'>
                        <label>New Password</label>
                        <input type='password' class='form-control' id='newPassword' />
                    </div>
                    `
                }).then(async (e) => {
                    if(e.isConfirmed) {
                        let password = document.getElementById('newPassword').value;
                        
                        let payload = {
                            id: vm.selected_user.id,
                            password: password
                        }

                        let fd = vm.payloadToFormdata(payload);

                        let res = await this.$axios('post', `/api/profile/emergency-change-password`, fd);

                        try {
                            if([200, 201].includes(res.status)){
                                this.$swal({
                                    title: 'Success',
                                    text: `${res.data.message}`,
                                    icon: 'success'
                                });
                            } else {
                                this.$swal({
                                    title: 'Error',
                                    text: `${res.data.message}`,
                                    icon: 'Error'
                                });
                            }
                        } catch (e) {
                            this.$swal({
                                title: 'Error',
                                text: 'Something went wrong',
                                icon: 'error'
                            });
                        }

                        vm.$nextTick(() => {
                            vm.selected_user = {};
                            show_change_password_btn: false;
                        });
                    }
                });
            }
        },

        mounted(){
            this.initApp();
        },
    }
</script>