import './bootstrap';
import { createApp } from 'vue';
import router from './route';
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import { LoadingPlugin } from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';
import axios from 'axios';
import Swal from "sweetalert2";
import NProgress from 'nprogress';
import 'nprogress/nprogress.css';
import VueGoodTablePlugin from 'vue-good-table-next';
import 'vue-good-table-next/dist/vue-good-table-next.css' //import the styles


const app = createApp({});

import NavbarComponent from './components/NavbarComponent.vue';
import SearchComponent from './components/searchComponent.vue';
import PaginationComponent from './components/PaginationComponent.vue';
import FooterComponent from './components/FooterComponent.vue';

app.component('navbar-component', NavbarComponent);
app.component('search-component', SearchComponent);
app.component('pagination-component', PaginationComponent);
app.component('footer-component', FooterComponent);

const options = {
    position: "top-right",
    timeout: 3000,
    closeOnClick: true,
    pauseOnFocusLoss: true,
    pauseOnHover: true,
    draggable: true,
    draggablePercent: 0.6,
    showCloseButtonOnHover: false,
    hideProgressBar: false,
    closeButton: "button",
    icon: true,
    rtl: false,
    transition: "Vue-Toastification__slideBlurred",
};

axios.interceptors.request.use((config) => {
    NProgress.start();
    return config;
}, (error) => {
    NProgress.done();
    return Promise.reject(error);
});

axios.interceptors.response.use((response) => {
    NProgress.done();
    return response;
}, (error) => {
    NProgress.done();
    return Promise.reject(error);
});

window.Swal = Swal;
app.config.globalProperties.axios = axios;
app.use(VueGoodTablePlugin);
app.use(LoadingPlugin);
app.use(Toast, options);
app.use(router);
app.mount('#app');
