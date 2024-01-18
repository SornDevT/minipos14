import { createWebHistory, createRouter } from "vue-router";

import Home from '../Pages/Home.vue';
import Store from '../Pages/Store.vue';
import Pos from '../Pages/Pos.vue';
import Transection from '../Pages/Transection.vue';
import Report from '../Pages/Report.vue';
import NoPage from '../Pages/No_page.vue';
import Login from '../Pages/Login.vue';
import Register from '../Pages/Register.vue';

import { useStore } from "../Store/auth";

const authMiddleware = (to, from, next) =>{
    const token = localStorage.getItem('web_token');
    const user = localStorage.getItem('web_user');
    const store = useStore();

    if(token){
        // ຖ້າມີ token ໃນ localStorage
        // ຂຽນຂໍ້ມູນ token ແລະ user ເຂົ້າໄປໃນ pinia
        store.set_token(token);
        store.set_user(user);
        next();
    } else {
        // ຖ້າບໍ່ມີ token ໃນ localStorage
        next({
            path: '/login',
            replace: true
        })
    }
}

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: 'store',
        path: '/store',
        component: Store,
        // meta: {
        //     middleware: [authMiddleware]
        // }
    },
    {
        name: 'pos',
        path: '/pos',
        component: Pos,
        meta: {
            middleware: [authMiddleware]
        }
    },
    {
        name: 'transection',
        path: '/transection',
        component: Transection,
        meta: {
            middleware: [authMiddleware]
        }
    },
    {
        name: 'report',
        path: '/report',
        component: Report,
        meta: {
            middleware: [authMiddleware]
        }
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

router.beforeEach((to,from,next)=>{
    const token = localStorage.getItem('web_token');
    if(to.meta.middleware){
        to.meta.middleware.forEach(middleware=>middleware(to, from, next))
    } else {
        if(to.path == '/login' || to.path == '/' ){
            if(token){
                next({
                    path:'/store',
                    replace: true
                })
            } else {
                next();
            }
        } else {
            next();
        }
    }
})

export default router;