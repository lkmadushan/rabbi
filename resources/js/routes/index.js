import { createWebHistory, createRouter } from 'vue-router'
import Welcome from '../pages/Welcome.vue'
import Instructions from '../pages/Instructions.vue'
import Quotes from '../pages/Quotes.vue'

const routes = [
    {
        path: '/',
        name: 'Welcome',
        component: Welcome,
    },
    {
        path: '/instructions',
        name: 'Instructions',
        component: Instructions,
    },
    {
        path: '/quotes',
        name: 'Quotes',
        component: Quotes,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
