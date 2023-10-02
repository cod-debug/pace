<template>
    <div>
        <div class="container">
            <div class="bg-white shadow-lg p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4><i class="fa fa-users"></i> Manage Users</h4>
                </div>
                <div class="border border-muted my-2"></div>
                <div class="mt-4">
                    <form class="form row" @submit.prevent="submitForm">
                        <div class="form-group col-md-6 my-2">
                            <label>Full Name </label>
                            <input type="text" class="form-control" v-model="name" required placeholder="First Name  M.I. Surname" />
                        </div>
                        <div class="form-group col-md-6 my-2">
                            <label>Type </label>
                            <select required v-model="type" class="form-select">
                                <option value="" selected disabled> - Select user type - </option>
                                <option value="user">Encoder</option>
                                <option value="admin">Administrator</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6 my-2">
                            <label>Email </label>
                            <input type="email" class="form-control" v-model="email" required />
                        </div>
                        <div class="form-group col-md-6 my-2">
                            <label>Password </label>
                            <input type="password" class="form-control" v-model="password" required />
                        </div>
                        <div class="form-group col-md-12 my-2 text-right">
                            <button class="btn btn-danger mx-2" type="button"><i class="fa fa-times-circle"></i> Reset</button>
                            <button class="btn btn-primary" type="submit"><i class="fa fa-check-circle"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: () => ({
            name: '',
            type: '',
            email: '',
            password: '',
        }),

        methods: {
            resetForm(){
                this.name = "";
            },

            async submitForm(){
                let payload = {
                    name: this.name,
                    type: this.type,
                    email: this.email,
                    password: this.password,
                }

                let fd = this.payloadToFormdata(payload);

                let res = await this.$axios('post', '/api/user/store', fd);

                if([200, 201].includes(res.status)){
                    this.$swal({
                        title: 'Success',
                        text: res.data.message,
                        icon: 'success'
                    });
                    this.resetfForm();
                } else {
                    this.$swal({
                        title: 'Error',
                        text: res.response.data.message,
                        icon: 'error'
                    });
                }
            }
        },

        mounted(){
            this.payment_date = this.current_date;
        },
        computed:{
            total(){
                return this.union_dues + this.ip_fund + this.fa;
            },
            current_date() {
                const today = new Date();
                const year = today.getFullYear();
                const month = String(today.getMonth() + 1).padStart(2, '0');
                const day = String(today.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            },
        },

    }
</script>