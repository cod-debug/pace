<template>
    <div>
        <div class="container">
            <div class="bg-white shadow-lg p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4><i class="fa fa-credit-card"></i> Agency Fee</h4>
                </div>
                <div class="border border-muted my-2"></div>
                <div class="mt-4">
                    <form class="form row" @submit.prevent="submitForm">
                        <div class="form-group col-md-6 my-2">
                            <label>Payment Date </label>
                            <input type="date" class="form-control" v-model="payment_date" required />
                        </div>
                        <div class="form-group col-md-6 my-2">
                            <label>Full Name </label>
                            <input type="text" class="form-control" v-model="full_name" required />
                        </div>
                        <div class="form-group col-md-6 my-2">
                            <label>Union Dues </label>
                            <input type="number" class="form-control" v-model="union_dues" required />
                        </div>
                        <div class="form-group col-md-6 my-2">
                            <label>I.P. Fund </label>
                            <input type="number" class="form-control" v-model="ip_fund" required />
                        </div>
                        <div class="form-group col-md-6 my-2">
                            <label>FA </label>
                            <input type="number" class="form-control" v-model="fa" required />
                        </div>
                        <div class="form-group col-md-6 my-2">
                            <label>Total </label>
                            <input type="text" class="form-control" :value="total" required readonly />
                        </div>
                        <div class="form-group col-md-12 my-2">
                            <label>Notes </label>
                            <textarea type="text" class="form-control" v-model="notes"></textarea>
                        </div>
                        <div class="form-group col-md-6 my-2"></div>
                        <div class="form-group col-md-6 my-2 text-right">
                            <button class="btn btn-danger mx-2" type="button" @click="resetfForm()"><i class="fa fa-times-circle"></i> Reset</button>
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
            payment_date: null,
            full_name: '',
            union_dues: 900,
            ip_fund: 300,
            fa: 1080,
            notes: '',
        }),

        methods: {
            resetfForm(){
                this.payment_date = this.current_date;
                this.full_name = '';
                this.union_dues = 900;
                this.ip_fund = 300;
                this.fa = 1080;
                this.notes = '';
            },

            async submitForm(){

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