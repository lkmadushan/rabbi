import { createWebHistory, createRouter } from 'vue-router'
import Instructions from '../pages/Instructions.vue'
import Quotes from '../pages/Quotes.vue'

const routes = [
    {
        path: '/',
        name: 'Quotes',
        component: Quotes,
    },
    {
        path: '/instructions',
        name: 'Instructions',
        component: Instructions,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
