<template>
    <div>
        <div class="container">
            <div class="bg-white shadow-lg p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4><i class="fa fa-file"></i> Add Employee Record</h4>
                    <div>
                        <button class="btn btn-info mr-2" @click="downloadEmployeeDataPdf"><i class="fa fa-download"></i> Save Info as PDF</button>
                        <button class="btn btn-success mx-2" @click="downloadEmployeeRecordPdf"><i class="fa fa-download"></i> Save Record as PDF</button>
                        <a href="/employee" class="btn btn-secondary"><i class="fa fa-users"></i> Back to Employee List</a>
                    </div>

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
                                        <td>
                                            <input type="date" v-model="record.payment_date" v-if="record.is_update" class="form-control" />
                                            <span v-else>{{ record.payment_date }}</span>
                                        </td>
                                        <td>
                                            <input type="text" v-model="record.particulars" v-if="record.is_update" class="form-control" />
                                            <span v-else>{{ record.particulars }}</span>
                                        </td>
                                        <td class="text-right">
                                            <input type="number" v-model="record.union_dues" v-if="record.is_update" class="form-control text-right" />
                                            <span v-else>₱ {{ record.union_dues }}</span>
                                        </td>
                                        <td class="text-right">
                                            <input type="number" v-model="record.ip_funds" v-if="record.is_update" class="form-control text-right" />
                                            <span v-else>₱ {{ record.ip_funds }}</span>
                                        </td>
                                        <td class="text-right">
                                            <input type="number" v-model="record.fa" v-if="record.is_update" class="form-control text-right" />
                                            <span v-else>₱ {{ record.fa }}</span>
                                        </td>
                                        <td>
                                            <input type="text" v-model="record.notes" v-if="record.is_update" class="form-control" />
                                            <span v-else>{{ record.notes }}</span>
                                        </td>
                                        <td class="text-right">
                                            ₱ {{ record.union_dues + record.ip_funds + record.fa }}
                                        </td>
                                        <td class="text-right">
                                            <button class="btn btn-success btn-sm" title="Update" v-if="!record.is_update" type="button" @click="confirmPassword(record_key)">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <div class="is_update" v-if="record.is_update">
                                                <button class="btn btn-secondary btn-sm" v-if="record.is_update" type="button" @click="updateRow(record_key)">
                                                    <i class="fa fa-cancel"></i>
                                                </button>
                                                <button class="btn btn-success btn-sm" title="Save Update" v-if="record.is_update" type="button" @click="saveRow(record_key)">
                                                    <i class="fa fa-check-circle"></i>
                                                </button>
                                            </div>
                                        </td>
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
        <div v-if="!loading_employee_info && !loading_employee_record" style="height: 0px!important; overflow: hidden;" >
            <div ref="employee_record_pdf">
                <app-employee-record-pdf :employee_data.sync="employee_data"
                    :getTotal.sync="getTotal"
                    :employee_record.sync="employee_record" />
            </div>
        </div>
        <div v-if="!loading_employee_info && !loading_employee_record" style="height: 0px!important; overflow: hidden;" >
            <div ref="employee_data_record_pdf">
                <app-employees-data-record-pdf :personal_info="employee_data" />
            </div>
        </div>
    </div>
</template>

<script>
    import __WEBPACK_EXTERNAL_MODULE_jspdf__ from 'html2pdf.js';
    import Loader from '../Reusables/Loader.vue';
    import EmployeeRecordPdf from './pdf/EmployeeRecordPdf.vue';
    import html2pdf from 'html2pdf.js';
    import Swal from 'sweetalert2';
    import EmployeesDataRecord from './pdf/EmployeesDataRecord.vue';
    export default {
        props:[
            'selected_id',
            'auth'
        ],
        components: {
            AppLoader: Loader,
            AppEmployeeRecordPdf: EmployeeRecordPdf,
            AppEmployeesDataRecordPdf: EmployeesDataRecord,
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

            loading_employee_info: true,
            loading_employee_record: true,

            auth_user: null,
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
            confirmPassword(key){
                
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
                        this.checkAuth(key);
                    }
                });
            },
            downloadEmployeeRecordPdf(){
                html2pdf(this.$refs.employee_record_pdf, {
                    margin: 10,
                    filename: `EMPLOYEE-RECORD_${this.employee_data.full_name.toUpperCase()}--${new Date()}.pdf`,
                });
            },
            downloadEmployeeDataPdf(){
                html2pdf(this.$refs.employee_data_record_pdf, {
                    margin: 10,
                    filename: `MEMBER-DATA_${this.employee_data.full_name.toUpperCase()}.pdf`,
                });
            },
            initApp(){        
                this.getEmployeeDetails();
                this.getRecords();
                this.payment_date = this.current_date;
                this.auth_user = JSON.parse(this.auth);
            },

            resetForm(){
                this.payment_date = this.current_date;
                this.particulars = '';
                this.union_dues = 75;
                this.ip_funds = 25;
                this.fa = 90;
                this.notes = '';
            },
            updateRow(key){
                this.employee_record[key].is_update =this.employee_record[key].is_update ? false : true;
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

            async checkAuth(key){
                let password = document.getElementById('confirmPassword').value;
                let payload = {
                    email: this.auth_user.email,
                    password: password,
                }

                let fd = this.payloadToFormdata(payload);
                
                let res = await this.$axios('post', `/api/auth/check`, fd);
                if([200, 201].includes(res.status)){
                    this.updateRow(key);
                } else {
                    this.$swal({
                        title: 'Error',
                        text: 'Invalid password',
                        icon: 'error'
                    });
                }
            },

            async getRecords(){
                try {
                    this.loading_employee_record = true;

                    let {data, status} = await this.$axios('get', `/api/employee/get-record/${this.selected_id}`);
                    if([200, 201].includes(status)){
                        console.log(data);
                        this.employee_record = data.data.map((i) => {
                            i.notes = i.notes == 'null' ? '' : i.notes;

                            return i;
                        });
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
                        this.resetForm();
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

            async saveRow(key){
                try {
                    let selected_row = this.employee_record[key];
                    
                    let payload = {
                        employee_id: parseInt(this.selected_id),
                        payment_date: selected_row.payment_date,
                        particulars: selected_row.particulars || '',
                        union_dues: selected_row.union_dues,
                        ip_funds: selected_row.ip_funds,
                        fa: selected_row.fa,
                        notes: selected_row.notes
                    }

                    let fd = this.payloadToFormdata(payload);

                    let res = await this.$axios('post', `/api/employee/update-record/${selected_row.id}`, fd);

                    if([200, 201].includes(res.status)){
                        this.$swal({
                            title: 'Success',
                            text: res.data.message,
                            icon: 'success'
                        });
                        this.employee_record[key].is_update = false;
                    } else {
                        this.$swal({
                            title: 'Error',
                            text: res.response.data.message,
                            icon: 'error'
                        });
                        this.employee_record[key].is_update = false;
                        this.getRecords();
                    }
                }
                catch(e) {
                    this.$swal({
                        title: 'Success',
                        text: 'Something went wrong during submission.',
                        icon: 'error'
                    });
                    console.log(e, "saveRow error");
                }
            }
        }
    }
</script>