<template>
    <div class="bg-white p-4 m-3">
        <div class="header text-center">
            <h4>PROGRESSIVE ALLIANCE OF CAPITOL EMPLOYEES (PACE)</h4>
            <h5>Provincial Government of Neg. Occ. 3rd Floor, Multi-Purpose Bldg., Gatuslao St., Brgy 4, Bacolod City</h5>
            <h5>Telephone No: (034) 4894838</h5>
        </div>
        <div class="personal_info mt-5">
            <strong><u>PERSONAL INFORMATION</u></strong>
            <table class="table table-bordered text-uppercase border border-secondary my-2">
                <tbody>
                    <tr>
                        <td colspan="2">Name: <b>{{ personal_info.full_name }}</b></td>
                    </tr>
                    <tr>
                        <td colspan="2">Department: <b>{{ personal_info.office.name }}</b></td>
                    </tr>
                    <tr>
                        <td colspan="2">Employment Status: <b>{{ personal_info.employment_status }}</b></td>
                    </tr>
                    <tr>
                        <td>Birth Date: <b>{{ personal_info.birth_date }}</b></td>
                        <td>Civil Status: <b>{{ personal_info.civil_status }}</b></td>
                    </tr>
                    <tr>
                        <td colspan="2">Home Address: <b>{{ personal_info.home_address }}</b></td>
                    </tr>
                    <tr>
                        <td colspan="2">Contact/Cell No.: <b>{{ personal_info.contact_number }}</b></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="legal_dependents text-uppercase mt-5">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-left"><strong><u>Legal Dependents</u></strong></th>
                        <th class="text-left"><strong><u>Name</u></strong></th>
                        <th class="text-left"><strong><u>Birth Date</u></strong></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, key) in personal_info.dependents" :key="key">
                        <td>{{ item.relationship }}</td>
                        <td>{{ item.name }}</td>
                        <td>{{ item.birth_date }}</td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</template>

<script>
    export default {
        props: ['personal_info'],
    }
</script>