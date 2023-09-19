<template>
    <div>
        <div class="container">
            <div class="bg-white shadow-lg p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4><i class="fa fa-file"></i> Add Employee Record</h4>
                    <a href="/employee" class="btn btn-secondary"><i class="fa fa-users"></i> Back to Employee List</a>
                </div>
                <div class="border border-muted my-2"></div>
                <div v-if="employee_data" class="my-4 mx-2">
                    <form @submit.prevent="submitForm" class="row">
                        <div class="form-group col-md-6 py-2">
                            <small class="text-muted">Full Name: </small>
                            <input type="text" v-model="employee_data.full_name" class="border-0  border-bottom form-control" readonly />
                        </div>
                        <div class="form-group col-md-6 py-2">
                            <small class="text-muted">Contact Number: </small>
                            <input type="text" v-model="employee_data.contact_number" class="border-0  border-bottom form-control" readonly />
                        </div>
                        <div class="form-group col-md-6 py-2">
                            <small class="text-muted">Office: </small>
                            <input type="text" v-model="employee_data.office.name" class="border-0  border-bottom form-control" readonly />
                        </div>
                        <div class="col-md-12 py-2">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Particulars</th>
                                        <th>Union Dues</th>
                                        <th>I.P. Fund</th>
                                        <th>FA</th>
                                        <th>Notes</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="date" v-model="form_date" class="form-control" /></td>
                                        <td><input type="text" v-model="particulars" class="form-control" /></td>
                                        <td><input type="number" v-model="union_dues" class="form-control" /></td>
                                        <td><input type="number" v-model="ip_funds" class="form-control" /></td>
                                        <td><input type="number" v-model="fa" class="form-control" /></td>
                                        <td><input type="text" v-model="notes" class="form-control" /></td>
                                        <td><input type="number" :value="union_dues+ip_funds+fa" readonly class="form-control" /></td>
                                        <td class="text-right">
                                            <button class="btn btn-primary my-auto"><i class="fa fa-save"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
                <div class="text-center" v-if="loading_employee_info">
                    <app-loader />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Loader from '../Reusables/Loader.vue';
    export default {
        props:[
            'selected_id'
        ],
        components: {
            AppLoader: Loader,
        },
        data: () => ({
            name: "RECORD",
            employee_data: null,

            form_date: null,
            particulars: null,
            union_dues: 75,
            ip_funds: 25,
            fa: 90,
            notes: null,
            total: null,

            loading_employee_info: false,
        }),
        mounted(){
            this.getEmployeeDetails();
        },
        methods: {
            async getEmployeeDetails(){
                try {
                    this.loading_employee_info = true;

                    let {data, status} = await this.$axios('get', `/api/employee/getOne/${this.selected_id}`);
                    if([200, 201].includes(status)){
                        this.employee_data = data;
                    } else {
                        this.employee_data = null;
                    }

                    this.loading_employee_info = false;
                } catch (e) {
                    console.log(e);
                }
            },

            async submitForm(){

            },
        }
    }
</script>