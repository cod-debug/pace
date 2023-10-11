<template>
    <div>
        <table class="table table-striped">
            <thead style="position: sticky; top: 0; background-color: white;">
                <tr>
                    <th width="30%">Office</th>
                    <th class="text-right" colspan="1" width="15%">Union Dues</th>
                    <th class="text-right" width="15%">I.P. Funds</th>
                    <th class="text-right" width="15%">FA</th>
                    <th class="text-right" width="15%">Total</th>
                </tr>
            </thead>
            <tbody  v-for="(office, office_key) in parentData.report_by_office" :key="office_key">
                <tr @click="office.show_employees = !office.show_employees ? true : false" style="cursor: pointer;">
                    <td colspan="1">{{ office.name }}</td>
                    <td class="text-right bg-success fw-bold text-white">
                        {{ parentData.getTotalUnionDuesByOffice(office.employees).toLocaleString() }}
                    </td>
                    <td class="text-right bg-success fw-bold text-white">
                        {{ parentData.getTotalIPFundsByOffice(office.employees).toLocaleString() }}
                    </td>
                    <td class="text-right bg-success fw-bold text-white">
                        {{ parentData.getTotalFAByOffice(office.employees).toLocaleString() }}
                    </td>
                    <td class="text-right bg-success fw-bold text-white">
                        {{ (parentData.getTotalUnionDuesByOffice(office.employees) + parentData.getTotalIPFundsByOffice(office.employees) + parentData.getTotalFAByOffice(office.employees)).toLocaleString() }}
                    </td>
                </tr>
                <tr v-for="(employee, emp_key) in office.employees" :key="emp_key" class="text-white" style="background-color: #6fa797;" v-if="office.show_employees ||  is_pdf">
                    <td colspan="5" class="p-0">
                        <table class="table table-hovered m-0">
                            <tbody>
                                <tr  @click="employee.show_particulars = !employee.show_particulars ? true : false" style="cursor: pointer;">
                                    <td class="text-white" width="30%">&nbsp; &nbsp; {{ employee.full_name }}</td>
                                    <td class="text-right text-white" width="15%">{{ parentData.getTotalUnionDues(employee.records) }}</td>
                                    <td class="text-right text-white" width="15%">{{ parentData.getTotalIPFunds(employee.records) }}</td>
                                    <td class="text-right text-white" width="15%">{{ parentData.getTotalFA(employee.records) }}</td>
                                    <td class="text-right text-white" width="15%">{{ parentData.getRowtotalByOffice(employee.records) }}</td>
                                </tr>
                                <tr v-for="(record, reecord_key) in employee.records" :key="reecord_key" style="background: #D6E5D6 ;" v-if="employee.show_particulars || is_pdf">
                                    <td class="" width="30%">&nbsp; &nbsp; &nbsp; &nbsp; {{ record.particulars }}</td>
                                    <td class="text-right text-dark" width="15%">{{ record.union_dues }}</td>
                                    <td class="text-right text-dark" width="15%">{{ record.ip_funds }}</td>
                                    <td class="text-right text-dark" width="15%">{{ record.fa }}</td>
                                    <td class="text-right text-dark" width="15%">{{ parentData.getRowtotal(record) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
            <tfoot style="position: sticky; bottom: 0; background-color: white;">
                <tr>
                    <td></td>
                    <td class="text-right fw-bold text-success" style="font-size: 16pt;">
                        {{ parentData.getTotalUnionDuesRecord(parentData.report_by_office) }}
                    </td>
                    <td class="text-right fw-bold text-success" style="font-size: 16pt;">
                        {{ parentData.getTotalIPRecord(parentData.report_by_office) }}
                    </td>
                    <td class="text-right fw-bold text-success" style="font-size: 16pt;">
                        {{ parentData.getTotalFARecord(parentData.report_by_office) }}
                    </td>
                    <td class="text-right fw-bold text-success" style="font-size: 16pt;">
                        {{ parentData.getTotal }}
                    </td>
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