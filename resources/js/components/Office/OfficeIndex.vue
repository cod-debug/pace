<template>
    <div>
        <div class="container">
            <div class="bg-white shadow-lg p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4><i class="fa fa-building"></i> List of Offices </h4>
                </div>
                <div class="border border-muted my-2"></div>

                <table class="table table-striped table-hovered" v-if="!is_loading_list">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th width="45%">
                                Office Name 
                                <button type="button" v-if="!show_form" class="btn btn-sm btn-success" @click="toggleShowForm"><i class="fa fa-plus-circle"></i></button>
                                <button type="button" v-if="show_form" class="btn btn-sm btn-danger" @click="toggleShowForm"><i class="fa fa-times-circle"></i></button>
                            </th>
                            <th width="30%">Desciption</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="show_form">
                            <td><input type="text" class="form-control" v-model="name" placeholder="Enter office name" /></td>
                            <td><input type="text" class="form-control" v-model="description" placeholder="Description" /></td>
                            <td class="text-right">
                                <button @click="saveOffice" :disabled="disabledSave" class="btn btn-primary" title="Save"><i class="fa fa-save"></i></button>
                                <button @click="cancelSave" v-if="is_update"  class="btn btn-secondary mx-1" title="Cancel"><i class="fa fa-cancel"></i></button>
                            </td>
                        </tr>
                        <tr v-for="(item, key) in list_data.data" :key="key">
                            <td>
                                {{ item.name }}
                            </td>
                            <td>
                                {{ item.description != 'null' ? item.description : '' }}
                            </td>
                            <td class="text-right">
                                <button class="btn btn-success btn-sm mx-1" @click="update(item)" v-if="selected_id != item.id || is_update"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-danger btn-sm" @click="confirmDelete(item)" v-if="selected_id != item.id || is_update"><i class="fa fa-trash"></i></button>
                                <div class="" v-if="show_confirm_delete && selected_id == item.id">
                                    <label class="mb-2"><input type="password" v-model="password" class="form-control" placeholder="Confirm Password"/></label>
                                    <br />
                                    <button class="btn btn-outline-danger btn-sm" @click="checkAuth(item.id)" title="Confirm delete?"><i class="fa fa-check-circle"></i> Yes</button>
                                    <button class="btn btn-outline-secondary btn-sm mx-1" @click="cancelDelete" title="Cancel delete?"><i class="fa fa-times-circle"></i> No</button>
                                </div>
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
        props: ['auth'],
        data: () => ({
            name: '',
            description: '',
            list_data: {},
            is_loading_list: false,
            selected_id: null,
            is_update: false,
            show_confirm_delete: false,
            show_form: false,
            auth_user: null,
            password: '',
        }),
        components: {
            AppLoader: Loader,
        },
        methods:{
            async saveOffice(){
                let payload = {
                    name: this.name,
                    description: this.description,
                } 

                let endpoint = '/office/store';

                if(this.is_update){
                    endpoint = '/office/update';
                    payload.id = this.selected_id;
                }
                try {
                    let {data,status} = await this.$axios('post', endpoint, this.payloadToFormdata(payload));
                    
                    if([200, 201].includes(status)){
                        this.$swal({
                            title: 'Success',
                            text: data.message,
                            icon: 'success'
                        });
                        this.clearForm();
                        this.getList();
                    } else {
                        this.$swal({
                            title: 'Success',
                            text: data.message,
                            icon: 'error'
                        });
                    }
                } catch (e) {
                    this.$swal({
                        title: 'Error',
                        text: 'Something went wrong during submission. Kindly contact the developer.',
                        icon: 'error'
                    });
                }
            },

            async checkAuth(id){
                let payload = {
                    email: this.auth_user.email,
                    password: this.password,
                }

                let fd = this.payloadToFormdata(payload);
                
                let res = await this.$axios('post', `/api/auth/check`, fd);
                if([200, 201].includes(res.status)){
                    this.removeOffice(id);
                } else {
                    this.$swal({
                        title: 'Error',
                        text: 'Invalid password',
                        icon: 'error'
                    });
                }
            },

            async removeOffice(id){
                let payload = {
                    status: 'deactivated',
                    id: id,
                } 
                try {
                    let {data,status} = await this.$axios('post', '/office/delete', this.payloadToFormdata(payload));
                    
                    if([200, 201].includes(status)){
                        this.$swal({
                            title: 'Success',
                            text: data.message,
                            icon: 'success'
                        });
                        this.clearForm();
                    } else {
                        this.$swal({
                            title: 'Success',
                            text: data.message,
                            icon: 'error'
                        });
                    }
                } catch (e) {
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
                    let {data, status} = await this.$axios('get','/office/list-api');
                    
                    if([200, 201].includes(status)){
                        this.list_data = data;
                    } else {
                        this.$swal({
                            title: 'Success',
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

            async getList(){
                try {
                    this.is_loading_list = true;
                    let {data, status} = await this.$axios('get','/office/list-api');
                    
                    if([200, 201].includes(status)){
                        this.list_data = data;
                    } else {
                        this.$swal({
                            title: 'Success',
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

            toggleShowForm(){
                this.show_form = !this.show_form;
            },
            update(item){
                this.name = item.name;
                this.description = item.description;
                this.selected_id = item.id;
                this.show_form = true;
                this.is_update = true;
            },
            cancelSave(){
                this.name = "";
                this.description = "";
                this.selected_id = null;
                this.is_update = false;
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
            clearForm(){
                this.name = "";
                this.description = "";
                this.selected_id = null;
                this.show_confirm_delete = false;
                this.getList();
            },
        },
        mounted(){
            this.getList();
            this.auth_user = JSON.parse(this.auth);
        },
        computed: {
            disabledSave(){
                return this.name == '' ? true : false;
            }
        },
    }
</script>