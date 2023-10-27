import { createRouter, createWebHistory } from 'vue-router';
import Home from './views/Home/Index.vue';
import Task from './views/Task/Index.vue';
import AddTask from './views/Task/Add.vue';
import EditTask from './views/Task/Edit.vue';
import Programmer from './views/Programmer/Index.vue';
import AddProgrammer from './views/Programmer/Add.vue';
import EditProgrammer from './views/Programmer/Edit.vue';

const routes = [
    { path: '/', name: 'Home', component: Home },
    { path: '/task', name: 'Task', component: Task },
    { path: '/task/add', name: 'AddTask', component: AddTask },
    { path: '/task/show/:id', name: 'EditTask', component: EditTask },
    { path: '/programmer', name: 'Programmer', component: Programmer },
    { path: '/programmer/add', name: 'AddProgrammer', component: AddProgrammer },
    { path: '/programmer/show/:id', name: 'EditProgrammer', component: EditProgrammer },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
