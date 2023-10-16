import { createRouter, createWebHistory } from 'vue-router';
import Home from './views/Home.vue';
import AddTask from './views/Task/Add.vue';
import EditTask from './views/Task/Edit.vue';

const routes = [
    { path: '/', name: 'Home', component: Home },
    { path: '/task', name: 'AddTask', component: AddTask },
    { path: '/task/show/:id', name: 'EditTask', component: EditTask },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;