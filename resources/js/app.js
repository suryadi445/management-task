import './bootstrap';
import { createApp } from 'vue';
import router from './route';
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

const app = createApp({});

import NavbarComponent from './components/NavbarComponent.vue';
import FooterComponent from './components/FooterComponent.vue';

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

app.use(Toast, options);
app.use(router);
app.mount('#app');
