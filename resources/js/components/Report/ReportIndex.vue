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
                        <div class="col-md-3">
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
                <div class="mt-4" v-if="!is_generating">
                    <button class="btn btn-success btn-sm" @click="downloadEmployeeRecordPdf"><i class="fa fa-download"></i> Save Employee Record as PDF</button>
                    <button class="btn btn-success btn-sm mx-2" @click="downloadAgencyFeePdf"><i class="fa fa-download"></i> Save Agency Fee Report PDF</button>
                </div>
                <div class="mt-4">
                    <div v-if="is_generating" class="text-center">
                        <app-loader />
                    </div>
                    <div class="table-responsive">
                        <div class="card" style="max-height: 400px!important; overflow: auto;"  v-if="['all', 'employee'].includes(report_type) && !is_generating">
                            <div class="card-header">
                                <h4>Employee Record</h4>
                            </div>
                            <div class="card-body">
                                <app-employee-record-table ref="employee_record_table" :is_pdf="false" />
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive mt-4">
                        <div class="card" style="max-height: 400px!important; overflow: auto;"  v-if="['all', 'agency'].includes(report_type) && !is_generating">
                            <div class="card-header">
                                <h4>Agency Fee</h4>
                            </div>
                            <div class="card-body">
                                <app-agency-fee-table ref="agency_fee_table" :is_pdf="false"  />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="height: 0px!important; overflow: hidden;" >
            <div ref="employee_record_table_pdf">
                <div class="text-center">
                    <h4>Progressive Alliance of Capitol Employees</h4>
                    <h5>(P A C E)</h5>
                    <div class="text-center">
                        <p>{{ as_of }}</p>
                    </div>
                </div>
                <app-employee-record-table :is_pdf="true" />
            </div>
            <div ref="agency_fee_table_pdf">
                <div class="text-center">
                    <h4>Progressive Alliance of Capitol Employees</h4>
                    <h5>(P A C E)</h5>
                    <div class="text-center">
                        <p>{{ as_of }}</p>
                    </div>
                </div>
                <app-agency-fee-table :is_pdf="true" />
            </div>
        </div>
    </div>
</template>

<script>
    import html2pdf from 'html2pdf.js';
    import Loader from '../Reusables/Loader.vue';
    import EmployeeRecordTable from './EmployeeRecordTable.vue';
    import AgencyFeeTable from './AgencyFeeTable.vue';
    export default {
        data: () => ({
            office: "",
            report_type: "all",
            date_from: null,
            date_to: null,

            is_report_submitted: false,
            is_generating: false,
            
            report_by_office: [],
            report_data: [],
            agency_fee_data: [],
            agency_fee_data_by_office: [],
            office_list: [],
        }),
        components: {
            AppLoader: Loader,
            AppEmployeeRecordTable: EmployeeRecordTable,
            AppAgencyFeeTable: AgencyFeeTable,
        },
        computed: {
            getAgencyTotal(){
                let total = 0;

                this.agency_fee_data.map((rec) => {
                    total+=rec.union_dues;
                    total+=rec.ip_funds;
                    total+=rec.fa;
                });

                return total.toLocaleString();
            },

            as_of(){
                let dateFrom = this.date_from;
                let dateTo = this.date_to;
                if(dateFrom == dateTo){
                    return this.$moment(dateFrom).format('MMMM DD, YYYY') 
                } else {
                    return this.$moment(dateFrom).format('MMMM DD, YYYY')+' to '+this.$moment(dateTo).format('MMMM DD, YYYY');   
                }
            },
        },
        methods: {
            downloadEmployeeRecordPdf(){
                html2pdf(this.$refs.employee_record_table_pdf, {
                    margin: 10,
                    filename: `EMPLOYEE-RECORD-REPORT-${this.as_of.replaceAll(' ', '_')}.pdf`,
                });
            },
            downloadAgencyFeePdf(){
                html2pdf(this.$refs.agency_fee_table_pdf, {
                    margin: 10,
                    filename: `AGENCY-FEE-REPORT-${this.as_of.replaceAll(' ', '_')}.pdf`,
                });
            },
            initApp(){
                this.getOffices();
            },
            getTotal(is_agency_fee = false){
                let total = 0;
                if(is_agency_fee){
                    this.agency_fee_data_by_office.map((office) => {
                        office.agency_fees.map((rec) => {
                            total+=rec.union_dues;
                            total+=rec.ip_funds;
                            total+=rec.fa;
                        });
                    })
                } else {
                    this.report_by_office.map((office) => {
                        office.employees.map((employee) => {
                            employee.records.map((rec) => {
                                total+=rec.union_dues;
                                total+=rec.ip_funds;
                                total+=rec.fa;
                            })
                        })
                    });
                }

                return total.toLocaleString();
            },
            getTotalUnionDuesRecord(offices, is_agency_fee = false){
                let total = 0;
                if(is_agency_fee){
                    offices.map((office) => {
                        office.agency_fees.map((record) => {
                            total+=record.union_dues
                        });
                    })
                } else {
                    offices.map((office) => {
                        office.employees.map((employee) => {
                            employee.records.map((record) => {
                                total+=record.union_dues
                            });
                        });
                    });
                }

                return total;
            },
            getTotalIPRecord(offices, is_agency_fee = false){
                let total = 0;
                offices.map((office) => {
                    if(is_agency_fee) {
                        office.agency_fees.map((record) => {
                            total+=record.ip_funds
                        });
                    } else {
                        office.employees.map((employee) => {
                            employee.records.map((record) => {
                                total+=record.ip_funds
                            });
                        });
                    }
                });

                return total;
            },
            getTotalFARecord(offices, is_agency_fee = false){
                let total = 0;
                offices.map((office) => {
                    if(is_agency_fee) {
                        office.agency_fees.map((record) => {
                            total+=record.fa
                        });
                    }
                    else{
                        office.employees.map((employee) => {
                            employee.records.map((record) => {
                                total+=record.fa
                            });
                        });
                    }
                });

                return total;
            },
            getTotalUnionDues(rec){
                let total = 0;
                if(rec.length === 0){
                    return total;
                }
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

            getTotalUnionDuesByOffice(emps){
                let ud = 0;
                emps.map((employee) => {
                    if(employee.records){
                        employee.records.map((record) => {
                            ud+=record.union_dues
                        })
                    } else {
                        ud+=employee.union_dues
                    }
                })

                return ud;
            },

            getTotalIPFundsByOffice(emps){
                let ip = 0;
                emps.map((employee) => {
                    if(employee.records){
                        employee.records.map((record) => {
                            ip+=record.ip_funds
                        })
                    } else {
                        ip+=employee.ip_funds
                    }
                })

                return ip;
            },

            getTotalFAByOffice(emps){
                let fa = 0;
                emps.map((employee) => {
                    if(employee.records){
                        employee.records.map((record) => {
                            fa+=record.fa
                        })
                    } else {
                        fa+=employee.fa
                    }
                })

                return fa;
            },

            getRowtotal(record){
               return record.union_dues+record.ip_funds+record.fa;
            },

            getRowtotalByOffice(records){
                let total = 0;
                records.map((record) => {
                    total+=record.union_dues+record.ip_funds+record.fa;
                })
                return total;
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
                    this.report_by_office = res.data.offices;
                    // this.report_data = res.data.employee_record;
                    // this.agency_fee_data = res.data.agency_fee;
                    this.agency_fee_data_by_office = res.data.offices;
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
