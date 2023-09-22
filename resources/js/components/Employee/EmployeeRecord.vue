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
                        <div class="form-group col-md-6 py-2">
                            <small class="text-muted">Total: </small>
                            <input type="text" :value="`₱ ${getTotal.toLocaleString()}`" class="border-0 form-control text-success" style="font-weight: bold; font-size: 24pt;" readonly />
                        </div>
                        
                        <div class="col-md-12 py-2">
                            <table class="table table-striped table-responsive">
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
                                    <tr class="bg-info">
                                        <td><input type="date" v-model="payment_date" class="form-control" /></td>
                                        <td><input type="text" v-model="particulars" class="form-control" /></td>
                                        <td><input type="number" v-model="union_dues" class="form-control text-right" /></td>
                                        <td><input type="number" v-model="ip_funds" class="form-control text-right" /></td>
                                        <td><input type="number" v-model="fa" class="form-control text-right" /></td>
                                        <td><input type="text" v-model="notes" class="form-control" /></td>
                                        <td><input type="number" :value="union_dues+ip_funds+fa" readonly class="form-control text-right" /></td>
                                        <td class="text-right">
                                            <button class="btn btn-primary my-auto"><i class="fa fa-save"></i></button>
                                        </td>
                                    </tr>
                                    <!-- <tr class="bg-success">
                                        <td class="fw-bold text-white">Subtotal</td>
                                        <td></td>
                                        <td class="text-right fw-bold text-white">₱ {{ getTotalUnionDues(employee_record) }}</td>
                                        <td class="text-right fw-bold text-white">₱ {{ getTotalIPFunds(employee_record) }}</td>
                                        <td class="text-right fw-bold text-white">₱ {{ getTotalFA(employee_record) }}</td>
                                        <td></td>
                                        <td class="text-right fw-bold text-white">₱ {{ getTotal.toLocaleString() }}</td>
                                        <td></td>
                                    </tr> -->
                                    <tr v-for="(record, record_key) in employee_record" :key="record_key">
                                        <td>{{ record.payment_date }}</td>
                                        <td>{{ record.particulars }}</td>
                                        <td class="text-right">₱ {{ record.union_dues }}</td>
                                        <td class="text-right">₱ {{ record.ip_funds }}</td>
                                        <td class="text-right">₱ {{ record.fa }}</td>
                                        <td>{{ record.notes || '--' }}</td>
                                        <td class="text-right">₱ {{ record.union_dues + record.ip_funds + record.fa }}</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
                <div class="text-center" v-if="loading_employee_info || loading_employee_record">
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
            employee_record: [],

            payment_date: null,
            particulars: '',
            union_dues: 75,
            ip_funds: 25,
            fa: 90,
            notes: '',
            total: null,

            loading_employee_info: false,
            loading_employee_record: false,
        }),
        mounted(){
            this.initApp();
        },
        computed:{
            current_date() {
                const today = new Date();
                const year = today.getFullYear();
                const month = String(today.getMonth() + 1).padStart(2, '0');
                const day = String(today.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            },

            getTotal(){
                let total = 0;

                this.employee_record.map((rec) => {
                    total+=rec.union_dues;
                    total+=rec.ip_funds;
                    total+=rec.fa;
                });

                return total.toLocaleString();
            },
        },
        methods: {
            initApp(){        
                this.getEmployeeDetails();
                this.getRecords();
                this.payment_date = this.current_date;
            },
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

            async getRecords(){
                try {
                    this.loading_employee_record = true;

                    let {data, status} = await this.$axios('get', `/api/employee/get-record/${this.selected_id}`);
                    if([200, 201].includes(status)){
                        console.log(data);
                        this.employee_record = data.data;
                    } else {
                        this.employee_record = [];
                    }

                    this.loading_employee_record = false;
                } catch (e) {
                    console.log(e);
                }
            },

            async submitForm(){
                try {
                    let payload = {
                        employee_id: this.selected_id,
                        payment_date: this.payment_date,
                        particulars: this.particulars || '',
                        union_dues: this.union_dues,
                        ip_funds: this.ip_funds,
                        fa: this.fa,
                        notes: this.notes
                    }

                    let fd = this.payloadToFormdata(payload);

                    let res = await this.$axios('post', `/api/employee/save-record`, fd);
                    
                    if([200, 201].includes(res.status)){
                        this.$swal({
                            title: 'Success',
                            text: res.data.message,
                            icon: 'success'
                        });
                        this.getRecords();
                    } else {
                        this.$swal({
                            title: 'Error',
                            text: res.response.data.message,
                            icon: 'error'
                        });
                    }

                } catch (e){
                    this.$swal({
                        title: 'Success',
                        text: 'Something went wrong during submission.',
                        icon: 'error'
                    });
                    console.log(e, "submitForm error");
                }


            },
        }
    }
</script>