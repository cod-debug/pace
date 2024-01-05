<template>
    <div>
        <table class="table table-striped">
            <thead :style="!is_pdf ? 'position: sticky; top: 0; background-color: white;' : ''">
                <tr>
                    <th width="20%">Office</th>
                    <th width="10%"></th>
                    <th class="text-right" colspan="1" width="10%">Union Dues</th>
                    <th class="text-right" width="10%">I.P. Funds</th>
                    <th class="text-right" width="10%">FA</th>
                    <th class="text-right" width="10%">Total</th>
                    <th class="text-right" width="10%">Notes</th>
                </tr>
            </thead>
            <tbody  v-for="(office, office_key) in parentData.report_by_office_agency_fee" :key="office_key">
                <tr @click="office.show_agency_fee = !office.show_agency_fee ? true : false" style="cursor: pointer;">
                    <td colspan="2" class="bg-success text-white">{{ office.name }}</td>
                    <td class="text-right bg-success fw-bold text-white">
                        {{ parentData.getTotalUnionDuesByOffice(office.agency_fees).toLocaleString() }}
                    </td>
                    <td class="text-right bg-success fw-bold text-white">
                        {{ parentData.getTotalIPFundsByOffice(office.agency_fees).toLocaleString() }}
                    </td>
                    <td class="text-right bg-success fw-bold text-white">
                        {{ parentData.getTotalFAByOffice(office.agency_fees).toLocaleString() }}
                    </td>
                    <td class="text-right bg-success fw-bold text-white">
                        {{ (parentData.getTotalUnionDuesByOffice(office.agency_fees) + parentData.getTotalIPFundsByOffice(office.agency_fees) + parentData.getTotalFAByOffice(office.agency_fees)).toLocaleString() }}
                    </td>
                    <td class="text-right bg-success fw-bold text-white"></td>
                </tr>
                <tr v-for="(employee, emp_key) in office.agency_fees" :key="emp_key" class="text-white" style="background-color: #6fa797;" v-if="office.show_agency_fee">
                    <td colspan="7" class="p-0">
                        <table class="table table-hovered m-0">
                            <tbody>
                                <tr>
                                    <td class="text-white" width="20%">&nbsp; &nbsp; {{ employee.full_name }}</td>
                                    <td class="text-white" width="10%">{{ employee.payment_date }}</td>
                                    <td class="text-right text-white" width="10%">{{ employee.union_dues }}</td>
                                    <td class="text-right text-white" width="10%">{{ employee.ip_funds }}</td>
                                    <td class="text-right text-white" width="10%">{{ employee.fa }}</td>
                                    <td class="text-right text-white" width="10%">{{ (employee.union_dues + employee.ip_funds + employee.fa) }}</td>
                                    <td class="text-right text-white" width="10%">{{ employee.notes }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
            <tfoot :style="!is_pdf ? 'position: sticky; bottom: 0; background-color: white;' : ''">
                <tr>
                    <td></td>
                    <td></td>
                    <td class="text-right fw-bold text-success" style="font-size: 16pt;">
                        {{ parentData.getTotalUnionDuesRecord(parentData.report_by_office_agency_fee, true).toLocaleString() }}
                    </td>
                    <td class="text-right fw-bold text-success" style="font-size: 16pt;">
                        {{ parentData.getTotalIPRecord(parentData.report_by_office_agency_fee, true).toLocaleString() }}
                    </td>
                    <td class="text-right fw-bold text-success" style="font-size: 16pt;">
                        {{ parentData.getTotalFARecord(parentData.report_by_office_agency_fee, true).toLocaleString() }}
                    </td>
                    <td class="text-right fw-bold text-success" style="font-size: 16pt;">
                        {{ parentData.getTotal(true) }}
                    </td>
                    <td></td>
                </tr>
            </tfoot>

        </table>
    </div>
</template>

<script>
    export default {
        props: [
            'is_pdf'
        ],
        computed:{
            parentData(){
                return this.$parent;
            }
        },
    }
</script>