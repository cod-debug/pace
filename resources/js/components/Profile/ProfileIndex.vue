<template>
    <div>
        <div class="container">
            <div class="bg-white shadow-lg p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4><i class="fa fa-id-card"></i> Profile </h4>
                </div>
                <div class="border border-muted my-2"></div>
                <!-- UPDATE PROFILE -->
                <div class="row p-5">
                    <div class="col-md-6">
                        <h3>Update your name</h3>
                        <p>You can use this form to update your account information. 
                            <br />
                            <span class="text-warning"><strong>Note:</strong> Email address serves as your identifier, you are not allowed to changed it.</span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <form @submit.prevent="updateProfile">
                                    <div class="form-group my-3">
                                        <label>Email Address</label>
                                        <input type="email" class="form-control" :value="auth_user.email" readonly />
                                    </div>
                                    <div class="form-group my-3">
                                        <label>Full Name</label>
                                        <input type="text" class="form-control" v-model="auth_user.name" />
                                    </div>
                                    <div class="form-group my-3 text-right">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i> Confirm</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ END OF UPDATE PROFILE -->

                <!-- UPDATE PASSWORD -->
                <div class="row p-5 mt-5">
                    
                    <div class="col-md-6">
                        <h3>Change password</h3>
                        <p>You can use this form to update your password. 
                            <br />
                            <span class="text-warning"><strong>Note:</strong> Email address serves as your identifier, you are not allowed to changed it.</span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <form @submit.prevent="changePassword">
                                    <div class="form-group my-3">
                                        <label>Old Password</label>
                                        <input type="password" class="form-control" v-model="password.old" />
                                    </div>
                                    <div class="form-group my-3">
                                        <label>New Password</label>
                                        <input type="password" class="form-control" v-model="password.new" />
                                    </div>
                                    <div class="form-group my-3">
                                        <label>Confirm Password</label>
                                        <input type="password" class="form-control" v-model="password.confirm" />
                                    </div>
                                    <div class="form-group my-3 text-right">
                                        <button type="submit" class="btn btn-secondary"><i class="fa fa-check-circle"></i> Confirm</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!--/ END UPDATE PASSWORD -->
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['auth'],
        data: () => ({
            auth_user: {},
            password: {
                old: '',
                new: '',
                confirm: ''
            },
        }),
        methods: {
            async changePassword(){
                if(this.password.new !== this.password.confirm){
                    this.$swal({
                        title: 'Error!',
                        text: 'Password does not match.',
                        icon: 'error'
                    });
                    return false;
                }

                let payload = {
                    id: this.auth_user.id,
                    old_password: this.password.old,
                    password: this.password.new,
                }

                let fd = this.payloadToFormdata(payload);

                try {
                    let res = await this.$axios('post', `/api/profile/change-password`, fd);
                    if([200, 201].includes(res.status)){
                        this.$swal({
                            title: 'Success!',
                            text: res.data.message,
                            icon: 'success'
                        });
                        this.password = {
                            old: '',
                            new: '',
                            confirm: ''
                        }
                    }
                } catch (e) {
                    this.$swal({
                        title: 'Error!',
                        text: 'Something went wrong.',
                        icon: 'error'
                    });
                    console.log(e);
                }
                
            },

            async updateProfile(){
                let payload = {
                    id: this.auth_user.id,
                    name: this.auth_user.name,
                }

                let fd = this.payloadToFormdata(payload);

                try {
                    let res = await this.$axios('post', `/api/profile/update`, fd);
                    if([200, 201].includes(res.status)){
                        this.$swal({
                            title: 'Success!',
                            text: res.data.message,
                            icon: 'success'
                        });
                        this.password = {
                            old: '',
                            new: '',
                            confirm: ''
                        }
                    }
                } catch (e) {
                    this.$swal({
                        title: 'Error!',
                        text: 'Something went wrong.',
                        icon: 'error'
                    });
                    console.log(e);
                }
                
            }
        },
        mounted(){
            this.auth_user = JSON.parse(this.auth);
        },
    }
</script>