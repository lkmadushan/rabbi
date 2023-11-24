import { createWebHistory, createRouter } from 'vue-router'
import Instructions from '../pages/Instructions.vue'
import Quotes from '../pages/Quotes.vue'

const routes = [
    {
        path: '/',
        name: 'quotes',
        component: Quotes,
    },
    {
        path: '/instructions',
        name: 'instructions',
        component: Instructions,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
