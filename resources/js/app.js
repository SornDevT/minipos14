import './bootstrap';


import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import MenuSidebar from './Components/MenuSidebar.vue'


const app = createApp(App);
app.component('MenuSidebar',MenuSidebar)
app.use(router)
app.mount('#app-vue');
