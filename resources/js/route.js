import { createRouter, createWebHistory } from 'vue-router';
import Home from './views/Home/Index.vue';
import Registrasi from './views/Home/Registrasi.vue';
import Task from './views/Task/Index.vue';
import AddTask from './views/Task/Add.vue';
import EditTask from './views/Task/Edit.vue';
import Karyawan from './views/Karyawan/Index.vue';
import AddKaryawan from './views/Karyawan/Add.vue';
import EditKaryawan from './views/Karyawan/Edit.vue';
import Absensi from './views/Absensi/Index.vue';
import Setting from './views/Setting/Index.vue';

const routes = [
    { path: '/', name: 'Home', component: Home },
    { path: '/registrasi', name: 'Registrasi', component: Registrasi },
    { path: '/task', name: 'Task', component: Task },
    { path: '/task/add', name: 'AddTask', component: AddTask },
    { path: '/task/show/:id', name: 'EditTask', component: EditTask },
    { path: '/karyawan', name: 'Karyawan', component: Karyawan },
    { path: '/karyawan/add', name: 'AddKaryawan', component: AddKaryawan },
    { path: '/karyawan/show/:id', name: 'EditKaryawan', component: EditKaryawan },
    { path: '/absensi', name: 'Absensi', component: Absensi },
    { path: '/setting', name: 'Setting', component: Setting },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
