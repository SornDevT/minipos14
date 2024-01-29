import './bootstrap';


import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import MenuSidebar from './Components/MenuSidebar.vue'

import {createPinia} from 'pinia';
const pinia = createPinia();

import Pagination from './Components/Pagination.vue'

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import Cleave from 'vue-cleave-component';


const app = createApp(App);
app.use(Cleave)
app.component('MenuSidebar',MenuSidebar)
app.component('Pagination',Pagination)
app.use(VueSweetalert2)
app.use(router)
app.use(pinia)
app.mount('#app-vue');
