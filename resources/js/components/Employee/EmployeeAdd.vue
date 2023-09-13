<template>
    <div>
        <div class="container">
            <div class="bg-white shadow-lg p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4><i class="fa fa-user-plus"></i> Add Employee</h4>
                    <a href="/employee" class="btn btn-secondary"><i class="fa fa-users"></i> Employee List</a>
                </div>
                <div class="border border-muted my-2"></div>
                <form class="form mt-2" @submit.prevent="submitForm">
                    <p class="text-right">
                        <strong>Date:</strong> <h5 class="border-bottom border-secondary d-inline-block">{{ formatDate }}</h5>
                    </p>
                    <div class="form-group p-3" v-if="step == 1">
                        <small class="text-muted">PERSONAL INFORMATION</small>
                        <div class="px-3 py-2">
                            <div class="row">
                                <div class="col-md-12 p-2">
                                    <div class="form-group">
                                        <label><b class="text-danger">*</b> NAME: </label>
                                        <input type="text" class="form-control" v-model="full_name">
                                    </div>
                                </div>
                                <div class="col-md-6 p-2">
                                    <div class="form-group">
                                        <label><b class="text-danger">*</b> DEPARTMENT: </label>
                                        <select name="department" required id="department" v-model="office_id" class="form-select">
                                            <option v-for="(item, key) in office_list" :key="key" :value="item.id">
                                                {{ item.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 p-2">
                                    <div class="form-group">
                                        <label><b class="text-danger">*</b> EMPLOYMENT STATUS: </label>
                                        <select name="employment_status" required id="employment_status" v-model="employment_status" class="form-select">
                                            <option v-for="(item, key) in employment_status_list" :key="key" :value="item">
                                                {{ item }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 p-2">
                                    <div class="form-group">
                                        <label><b class="text-danger">*</b> BIRTH DATE: </label>
                                        <input type="date" class="form-control" v-model="birth_date">
                                    </div>
                                </div>
                                <div class="col-md-6 p-2">
                                    <div class="form-group">
                                        <label><b class="text-danger">*</b> CIVIL STATUS: </label>
                                        <select name="civil_status" required id="civil_status" v-model="civil_status" class="form-select">
                                            <option v-for="(item, key) in civil_status_list" :key="key" :value="item">
                                                {{ item }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 p-2">
                                    <div class="form-group">
                                        <label><b class="text-danger">*</b> HOME ADDRESS: </label>
                                        <input type="text" class="form-control" v-model="home_address">
                                    </div>
                                </div>
                                <div class="col-md-12 p-2">
                                    <div class="form-group">
                                        <label><b class="text-danger">*</b> CONTACT / CELL NUMBER: </label>
                                        <input type="text" class="form-control" v-model="contact_number">
                                    </div>
                                </div>
                                <div class="col-md-6 p-2">
                                    <div class="form-group">
                                        <label>EMAIL ADDRESS: </label>
                                        <input type="text" class="form-control" v-model="email">
                                    </div>
                                </div>
                                <div class="col-md-6 p-2">
                                    <div class="form-group">
                                        <label>FACEBOOK ACCOUNT: </label>
                                        <input type="text" class="form-control" v-model="facebook_account">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group p-3 bg-light" v-if="step == 2">
                        <div class="form-group w-50">
                            <label class="w-50">
                                <input type="checkbox" v-model="is_single" /> SINGLE
                            </label>
                        </div>
                        <br />
                        <div>
                            <div class="d-flex justify-content-between">
                                <small class="text-muted">
                                    LEGAL DEPENDENTS 
                                </small>
                                <button type="button" class="btn btn-sm btn-success float-right" @click="addDependent" v-if="!dependents_has_limit">
                                    <i class="fa fa-plus-circle"></i>
                                </button>
                            </div>
                            <div class="px-3 py-2">
                                <table class="table table-striped table">
                                    <thead>
                                        <tr>
                                            <td width="35%">RELATIONSHIP</td>
                                            <td width="30%">NAME</td>
                                            <td>BIRTHDAY</td>
                                            <td v-if="!dependents_has_limit"></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, key) in dependents" :key="key">
                                            <th>
                                                <div class="row">
                                                    <div :class="item.relationship == 'DESIGNATED' ? 'col-md-5': 'col-md-12'">
                                                        <select v-model="item.relationship" class="form-select">
                                                            <option :value="d_type" v-for="(d_type, k) in dependent_type_option" :key="k">{{ d_type }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-7" v-if="item.relationship == 'DESIGNATED'">
                                                        <input type="text" placeholder="SPECIFY RELATIONSHIP" v-model="item.relationship_designated" class="form-control" />
                                                    </div>
                                                </div>
                                            </th>
                                            <td>
                                                <input type="text" v-model="item.name" class="form-control" />
                                            </td>
                                            <td>
                                                <input type="date" v-model="item.birth_date" class="form-control" />
                                            </td>
                                            <td v-if="!dependents_has_limit">
                                                <button type="button" class="btn btn-outline-danger" @click="removeDependent(key)"><i class="fa fa-minus-circle"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex" :class="step == 1 ? 'justify-content-end' : 'justify-content-between'">
                        <button class="btn btn-outline-secondary" type="button" v-if="step > 1" @click="step--"><i class="fa fa-caret-left"></i> Back</button>
                        <button class="btn btn-outline-primary" type="button" v-if="step < last_step" @click="step++">{{next_btn_text}} <i class="fa fa-caret-right"></i></button>
                        <button class="btn btn-primary" v-if="step == last_step">Submit <i class="fa fa-caret-right"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>


<script>
const PARENT_DEPENDENTS_DEFAULT = [
    {
        relationship: 'MOTHER',
        birth_date: null,
        name: ''
    },
    {
        relationship: 'FATHER',
        birth_date: null,
        name: ''
    }
];
const DESIGNATED_DEPENDENTS_DEFAULT = [
    {
        relationship: '',
        birth_date: null,
        name: ''
    },
    {
        relationship: '',
        birth_date: null,
        name: ''
    },
];

const SPOUSE_DEPENDENTS_DEFAULT = [
    {
        relationship: 'SPOUSE',
        birth_date: null,
        name: ''
    },
];

const SINGLE_DEPENDENTS_DEFAULT = [
    {
        relationship: '',
        birth_date: null,
        name: ''
    },
    {
        relationship: '',
        birth_date: null,
        name: ''
    },
];

const MARRIED_DEPENDENTS_DEFAULT = [
    {
        relationship: '',
        birth_date: null,
        name: ''
    },
];

const SINGLE_DEPENDENT_TYPE_OPTION = ['MOTHER', 'FATHER', 'DESIGNATED', 'CHILD'];
const MARRIED_DEPENDENT_TYPE_OPTION = ['MOTHER', 'FATHER','SPOUSE', 'CHILD'];

    export default {
        data: () => ({
            full_name: '',
            office_id: null,
            employment_status: 'employed',
            civil_status: '',
            home_address: '',
            contact_number: '',
            email: '',
            facebook_account: '',
            birth_date: '',

            
            is_single: false,
            dependent_type: '', // PARENTS / DESIGNATED / SPOUSE
            dependents_has_limit: false,
            dependent_type_option: MARRIED_DEPENDENT_TYPE_OPTION,
            dependents: MARRIED_DEPENDENTS_DEFAULT,

            has_children: false,
            step: 1,
            last_step: 3,
            children: [
                {
                    name: '',
                }
            ],

            office_list: [],
            employment_status_list: ['Employed', 'Retired'],
            civil_status_list: ['Single', 'Married', 'Widowed'],
        }),
        watch: {

            is_single(newVal){
                this.dependent_type = "";
                if(newVal){
                    this.dependents_has_limit = true;
                    this.dependents = [
                        {
                            relationship: '',
                            birth_date: null,
                            name: ''
                        },
                        {
                            relationship: '',
                            birth_date: null,
                            name: ''
                        },
                    ];
                    this.dependent_type_option = SINGLE_DEPENDENT_TYPE_OPTION;
                } else {
                    this.dependents_has_limit = false;
                    this.dependents = [
                        {
                            relationship: '',
                            birth_date: null,
                            name: ''
                        },
                    ];
                    this.dependent_type_option = MARRIED_DEPENDENT_TYPE_OPTION;
                    
                }
            },
        },
        computed:{
            formatDate() {
                let date = new Date();
                const options = { year: 'numeric', month: 'long', day: 'numeric' };
                return date.toLocaleDateString(undefined, options);
            },

            next_btn_text(){
                return this.step == this.last_step - 1 ? 'Preview' : 'Next';
            }
        },

        mounted(){
            this.getOffices();
        },

        methods: {
            addDependent(){
                this.dependents.push({
                    name: '',
                    email: '',
                    facebook: ''
                });
            },
            removeDependent(key){
                this.dependents.splice(key, 1);
            },
            async submitForm(){
                let vm = this;

                let payload = {
                    full_name: this.full_name,
                    office_id: this.office_id,
                    employment_status: this.employment_status,
                    birth_date: this.birth_date,
                    civil_status: this.civil_status,
                    home_address: this.home_address,
                    contact_number: this.contact_number,
                    email_address:  this.email,
                    facebook_account:  this.facebook_account,
                    dependents: JSON.stringify(this.dependents)
                }

                let formdata = this.payloadToFormdata(payload);
                let {data, status} = await this.$axios('post', '/api/employee/store', formdata);
                 
                if([200, 201].includes(status)){
                    console.log(data);
                }
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
        }
    }
</script>