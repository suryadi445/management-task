import './bootstrap';
import { createApp } from 'vue';
import router from './route';
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import { LoadingPlugin } from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';
import axios from 'axios';




const app = createApp({});

import PaginationComponent from './components/PaginationComponent.vue';
import NavbarComponent from './components/NavbarComponent.vue';
import FooterComponent from './components/FooterComponent.vue';

app.component('pagination-component', PaginationComponent);
app.component('navbar-component', NavbarComponent);
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

app.config.globalProperties.axios = axios; // Menetapkan axios sebagai properti global
app.use(LoadingPlugin);
app.use(Toast, options);
app.use(router);
app.mount('#app');
