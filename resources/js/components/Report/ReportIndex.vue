<template>
    <div>
        <div class="container">
            <div class="bg-white shadow-lg p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4><i class="fa fa-chart-simple"></i> Generate Report</h4>
                </div>
                <div class="border border-muted my-2"></div>
                <div class="mt-4">
                    <form class="row form" @submit.prevent="submitForm">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Report Type</label>
                                <select class="form-select" v-model="report_type">
                                    <option value="all">All</option>
                                    <option value="employee">Employee Record</option>
                                    <option value="agency">Agency Fee</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3" v-if="['all', 'employee'].includes(report_type)">
                            <div class="form-group">
                                <label>Office</label>
                                <select class="form-select" v-model="office">
                                    <option value="">All</option>
                                    <option v-for="(office, office_key) in office_list" :value="office.id" :key="office_key" class="text-capitalize">{{ office.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Date From: </label>
                                <input type="date" v-model="date_from" required class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Date To: </label>
                                <input type="date" v-model="date_to" required class="form-control" />
                            </div>
                        </div>
                        <div class="text-right col-12 my-4">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i> Generate</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="container mt-4" v-if="is_report_submitted">
            <div class="bg-white shadow-lg p-3">
                <div class="text-right">
                    <a style="cursor: pointer;" v-if="!is_generating" @click="is_report_submitted = false">[x]</a>
                </div>
                <div class="mt-4">
                    <div v-if="is_generating" class="text-center">
                        <app-loader />
                    </div>
                    <div class="table-responsive" style="max-height: 400px!important; overflow: auto;"  v-if="['all', 'employee'].includes(report_type) && !is_generating">
                        <h4>Employee Record</h4>
                        <table class="table table-striped">
                            <thead style="position: sticky; top: 0; background-color: white;">
                                <tr>
                                    <th>Payment Date</th>
                                    <th>Name</th>
                                    <th>Contact Number</th>
                                    <th>Office</th>
                                    <th>Particulars</th>
                                    <th>Notes</th>
                                    <th class="text-right">Union Dues</th>
                                    <th class="text-right">I.P. Funds</th>
                                    <th class="text-right">FA</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(record, record_key) in report_data" :key="record_key">
                                    <td>
                                        {{ record.payment_date }}
                                    </td>
                                    <td>
                                        {{ record.employee.full_name }}
                                    </td>
                                    <td>
                                        {{ record.employee.contact_number }}
                                    </td>
                                    <td>
                                        {{ record.employee.office.name }}
                                    </td>
                                    <td>
                                        {{ record.particulars }}
                                    </td>
                                    <td>
                                        {{ record.notes || '--' }}
                                    </td>
                                    <td class="text-right bg-info fw-bold text-white">
                                        {{ record.union_dues }}
                                    </td>
                                    <td class="text-right bg-info fw-bold text-white">
                                        {{ record.ip_funds }}
                                    </td>
                                    <td class="text-right bg-info fw-bold text-white">
                                        {{ record.fa }}
                                    </td>
                                    <td class="text-right bg-info fw-bold text-white">
                                        {{ getRowtotal(record) }}
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot style="position: sticky; bottom: 0; background-color: white;">
                                <tr>
                                    <td colspan="6"></td>
                                    <td class="text-right fw-bold text-success" style="font-size: 16pt;">
                                        {{ getTotalUnionDues(report_data) }}
                                    </td>
                                    <td class="text-right fw-bold text-success" style="font-size: 16pt;">
                                        {{ getTotalIPFunds(report_data) }}
                                    </td>
                                    <td class="text-right fw-bold text-success" style="font-size: 16pt;">
                                        {{ getTotalFA(report_data) }}
                                    </td>
                                    <td class="text-right fw-bold text-success" style="font-size: 16pt;">
                                        {{ getTotal }}
                                    </td>
                                </tr>
                            </tfoot>

                        </table>
                    </div>
                    <div class="table-responsive" style="max-height: 400px!important; overflow: auto;"  v-if="['all', 'agency'].includes(report_type) && !is_generating">
                        <h4>Agency Fee</h4>
                        <table class="table table-striped">
                            <thead style="position: sticky; top: 0; background-color: white;">
                                <tr>
                                    <th>Payment Date</th>
                                    <th>Name</th>
                                    <th>Notes</th>
                                    <th class="text-right">Union Dues</th>
                                    <th class="text-right">I.P. Funds</th>
                                    <th class="text-right">FA</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(record, record_key) in agency_fee_data" :key="record_key">
                                    <td>
                                        {{ record.payment_date }}
                                    </td>
                                    <td>
                                        {{ record.full_name }}
                                    </td>
                                    <td>
                                        {{ record.notes || '--' }}
                                    </td>
                                    <td class="text-right bg-info fw-bold text-white">
                                        {{ record.union_dues }}
                                    </td>
                                    <td class="text-right bg-info fw-bold text-white">
                                        {{ record.ip_funds }}
                                    </td>
                                    <td class="text-right bg-info fw-bold text-white">
                                        {{ record.fa }}
                                    </td>
                                    <td class="text-right bg-info fw-bold text-white">
                                        {{ getRowtotal(record) }}
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot style="position: sticky; bottom: 0; background-color: white;">
                                <tr>
                                    <td colspan="3"></td>
                                    <td class="text-right fw-bold text-success" style="font-size: 16pt;">
                                        {{ getTotalUnionDues(agency_fee_data) }}
                                    </td>
                                    <td class="text-right fw-bold text-success" style="font-size: 16pt;">
                                        {{ getTotalIPFunds(agency_fee_data) }}
                                    </td>
                                    <td class="text-right fw-bold text-success" style="font-size: 16pt;">
                                        {{ getTotalFA(agency_fee_data) }}
                                    </td>
                                    <td class="text-right fw-bold text-success" style="font-size: 16pt;">
                                        {{ getAgencyTotal }}
                                    </td>
                                </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Loader from '../Reusables/Loader.vue';
    export default {
        data: () => ({
            office: "",
            report_type: "all",
            date_from: null,
            date_to: null,

            is_report_submitted: false,
            is_generating: false,

            report_data: [],
            agency_fee_data: [],
            office_list: [],
        }),
        components: {
            AppLoader: Loader,
        },
        computed: {
            getTotal(){
                let total = 0;

                this.report_data.map((rec) => {
                    total+=rec.union_dues;
                    total+=rec.ip_funds;
                    total+=rec.fa;
                });

                return total.toLocaleString();
            },
            getAgencyTotal(){
                let total = 0;

                this.agency_fee_data.map((rec) => {
                    total+=rec.union_dues;
                    total+=rec.ip_funds;
                    total+=rec.fa;
                });

                return total.toLocaleString();
            },
        },
        methods: {
            initApp(){
                this.getOffices();
            },
            getTotalUnionDues(rec){
                let total = 0;

                rec.map((r) => {
                    total+=r.union_dues
                });

                return total.toLocaleString();
            },
            getTotalIPFunds(rec){
                let total = 0;

                rec.map((r) => {
                    total+=r.ip_funds
                });

                return total.toLocaleString();
            },
            getTotalFA(rec){
                let total = 0;

                rec.map((r) => {
                    total+=r.fa
                });

                return total.toLocaleString();
            },
            getRowtotal(record){
               return record.union_dues+record.ip_funds+record.fa;
            },
            async submitForm(){
                this.is_report_submitted = true;
                this.is_generating = true;

                let payload = {
                    office: this.office,
                    date_from: this.date_from,
                    date_to: this.date_to
                }

                let fd = this.payloadToFormdata(payload);
                
                let res = await this.$axios('post', `/api/report/generate`, fd);
                
                if([200, 201].includes(res.status)){
                    this.report_data = res.data.employee_record;
                    this.agency_fee_data = res.data.agency_fee;
                } else {
                    this.$swal({
                        title: 'Error',
                        text: res.response.data.message,
                        icon: 'error'
                    });
                }
                
                this.is_generating = false;
            },

            async getOffices(){
                try {
                    this.is_loading_list = true;
                    let {data, status} = await this.$axios('get','/office/list-all-api');
                    
                    if([200, 201].includes(status)){
                        this.office_list = data;
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
        },
        mounted(){
            this.initApp();
        },
    }
</script>
