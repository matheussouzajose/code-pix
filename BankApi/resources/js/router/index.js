import { createRouter, createWebHistory } from 'vue-router'
import Dashboard from "../pages/Dashboard.vue";

const routerHistory = createWebHistory()

const index = createRouter({
    history: routerHistory,
    routes: [
        {
            path: '/dashboard',
            name: 'dashboard',
            component: Dashboard,
        },
        {
            path: '/:pathMatch(.*)*',
            redirect: { name: 'dashboard' }
        }
    ]
})

export default index
