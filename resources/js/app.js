import './bootstrap';

import { createApp } from 'vue';
import Example from './components/Example.vue';
import OfficeIndex from './components/Office/OfficeIndex.vue';
import EmployeeList from './components/Employee/EmployeeList.vue';
import EmployeeAdd from './components/Employee/EmployeeAdd.vue';

const app = createApp({
    components: {
        Example,
        AppOffice: OfficeIndex,
        AppEmployeeList: EmployeeList,
        AppEmployeeAdd: EmployeeAdd,
    }
});

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