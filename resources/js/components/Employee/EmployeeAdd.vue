<template>
    <div>
        <div class="container">
            <div class="bg-white shadow-lg p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4><i class="fa fa-user-plus"></i> Add Employee</h4>
                    <a href="/employee" class="btn btn-secondary"><i class="fa fa-users"></i> Employee List</a>
                </div>
                <div class="border border-muted my-2"></div>
                <form class="form mt-2" >
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
                                        <select name="department" required id="department" v-model="department" class="form-control">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 p-2">
                                    <div class="form-group">
                                        <label><b class="text-danger">*</b> EMPLOYMENT STATUS: </label>
                                        <select name="department" required id="department" class="form-control">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 p-2">
                                    <div class="form-group">
                                        <label><b class="text-danger">*</b> NAME: </label>
                                        <input type="date" class="form-control" v-model="full_name">
                                    </div>
                                </div>
                                <div class="col-md-6 p-2">
                                    <div class="form-group">
                                        <label><b class="text-danger">*</b> CIVIL STATUS: </label>
                                        <input type="text" class="form-control" v-model="full_name">
                                    </div>
                                </div>
                                <div class="col-md-12 p-2">
                                    <div class="form-group">
                                        <label><b class="text-danger">*</b> HOME ADDRESS: </label>
                                        <input type="text" class="form-control" v-model="full_name">
                                    </div>
                                </div>
                                <div class="col-md-12 p-2">
                                    <div class="form-group">
                                        <label><b class="text-danger">*</b> CONTACT / CELL NUMBER: </label>
                                        <input type="text" class="form-control" v-model="full_name">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group p-3 bg-light" v-if="step == 2">
                        <small class="text-muted">LEGAL DEPENDENTS</small>
                        <div class="px-3 py-2">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td></td>
                                        <td>NAME</td>
                                        <td>BIRTHDAY</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>MOTHER</th>
                                        <td>
                                            <input type="text" class="form-control" />
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>FATHER</th>
                                        <td>
                                            <input type="text" class="form-control" />
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>SPOUSE</th>
                                        <td>
                                            <input type="text" class="form-control" />
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group p-3" v-if="step == 2">
                        <small class="text-muted []">
                            <label>
                                <input type="checkbox" v-model="has_children" /> CHILDREN (21  YEARS OLD & BELOW)
                            </label> 
                        </small>
                        <button class="btn btn-sm btn-success" type="button" @click="addChildren" v-if="has_children">
                            <i class="fa fa-plus"></i>
                        </button>
                        <div class="px-3 py-2" v-if="has_children">
                            <table class="table table-striped w-50">
                                <thead>
                                    <tr>
                                        <td width="40%">Name</td>
                                        <td v-if="children.length > 1"></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, key) in children" :key="key">
                                        <td><input required type="text" class="form-control" v-model="item.name" /></td>
                                        <td v-if="children.length > 1"><button class="btn btn-sm btn-danger" @click="removeChild(key)"><i class="fa fa-minus"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex" :class="step == 1 ? 'justify-content-end' : 'justify-content-between'">
                        <button class="btn btn-outline-secondary btn-sm" type="button" v-if="step > 1" @click="step--"><i class="fa fa-caret-left"></i> Back</button>
                        <button class="btn btn-outline-primary btn-sm" type="button" v-if="step < last_step" @click="step++">Next <i class="fa fa-caret-right"></i></button>
                        <button class="btn btn-primary btn-sm" type="button" v-if="step == last_step">Submit <i class="fa fa-caret-right"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        data: () => ({
            full_name: '',
            department: '',
            has_children: false,
            step: 1,
            last_step: 3,
            children: [
                {
                    name: '',
                }
            ],
        }),
        watch: {
            has_children(newVal){
                if(!newVal){
                    this.children = [
                        {
                            name: '',
                        }
                    ];
                }
            }
        },
        computed:{
            formatDate() {
                let date = new Date();
                const options = { year: 'numeric', month: 'long', day: 'numeric' };
                return date.toLocaleDateString(undefined, options);
            }
        },

        methods: {
            addChildren(){
                this.children.push({
                    name: '',
                    email: '',
                    facebook: ''
                });
            },
            removeChild(key){
                this.children.splice(key, 1);
            }
        }
    }
</script>