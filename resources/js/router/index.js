import { createWebHistory, createRouter } from "vue-router";

import Home from '../Pages/Home.vue';
import Store from '../Pages/Store.vue';
import Pos from '../Pages/Pos.vue';
import Transection from '../Pages/Transection.vue';
import Report from '../Pages/Report.vue';
import NoPage from '../Pages/No_page.vue';


export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'store',
        path: '/store',
        component: Store
    },
    {
        name: 'pos',
        path: '/pos',
        component: Pos
    },
    {
        name: 'transection',
        path: '/transection',
        component: Transection
    },
    {
        name: 'report',
        path: '/report',
        component: Report
    },
    {
        name: 'no_page',
        path: '/:pathMacth(.*)*',
        component: NoPage
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
    scrollBehavior(){
        window.scrollTo(0,0)
    }
});

export default router;