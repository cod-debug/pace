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

app.mount('#app');