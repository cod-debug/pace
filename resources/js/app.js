import './bootstrap';

import { createApp } from 'vue';
import Example from './components/Example.vue';

import OfficeIndex from './components/Office/OfficeIndex.vue';
import OfficeAdd from './components/Office/OfficeAdd.vue';

import EmployeeList from './components/Employee/EmployeeList.vue';
import EmployeeAdd from './components/Employee/EmployeeAdd.vue';
import EmployeeRecord from './components/Employee/EmployeeRecord.vue';

import ReportIndex from './components/Report/ReportIndex.vue';

import AgencyFeeIndex from './components/AgencyFee/AgencyFeeIndex.vue';

import UserIndex from './components/Users/UserIndex.vue';

import VueAwesomePaginate from "vue-awesome-paginate";

import Swal from 'sweetalert2';

const app = createApp({
    components: {
        Example,
        AppOffice: OfficeIndex,
        AppOfficeAdd: OfficeAdd,
        AppEmployeeList: EmployeeList,
        AppEmployeeAdd: EmployeeAdd,
        AppEmployeeRecord: EmployeeRecord,
        AppReportIndex: ReportIndex,
        AppAgencyFeeIndex: AgencyFeeIndex,
        AppUserIndex: UserIndex,
    }
});

app.use(VueAwesomePaginate);

app.mixin({
    methods:{
        $axios: async (method = 'get', endpoint = '', payload = {}, options={}) => {
            try {
                let data = await axios[method](endpoint, payload);
                return data;
            } catch (e) {
                return e
            }
        },
        $swal(options){
            Swal.fire(options);
        },
        truncateText(text, limit) {
            if (text.length <= limit) {
                return text;
            } else {
                return text.slice(0, limit) + '...';
            }
        },

        csrf_token(){
            return document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },

        payloadToFormdata(payload){
            let formD = new FormData();

            for(const key in payload){
                formD.append(key, payload[key]);
            }

            return formD;
        },
    }
});

app.mount('#app');