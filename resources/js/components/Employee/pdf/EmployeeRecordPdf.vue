<template>
    <div>
        <div class="row">
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
                <p style="font-weight: bold; font-size: 24pt;" class="text-success">₱ {{getTotal.toLocaleString()}}</p>
            </div>
            
            <div class="col-md-12 py-2">
                <table class="table table-striped table-responsive">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Particulars</th>
                            <th class="text-right">Union Dues</th>
                            <th class="text-right">I.P. Fund</th>
                            <th class="text-right">FA</th>
                            <th>Notes</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(record, record_key) in employee_record" :key="record_key">
                            <td>{{ record.payment_date }}</td>
                            <td>{{ record.particulars }}</td>
                            <td class="text-right">₱ {{ record.union_dues }}</td>
                            <td class="text-right">₱ {{ record.ip_funds }}</td>
                            <td class="text-right">₱ {{ record.fa }}</td>
                            <td>{{ record.notes || '--' }}</td>
                            <td class="text-right">₱ {{ record.union_dues + record.ip_funds + record.fa }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['employee_data', 'getTotal', 'employee_record'],
        mounted(){
            console.log(this.employee_data);
        },
    }
</script>