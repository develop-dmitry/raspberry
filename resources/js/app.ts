import './bootstrap';
import {createApp} from "vue";
import {createRouter, createWebHistory} from "vue-router";
import routes from './routes';
import {createPinia} from "pinia";

const router = createRouter({
    history: createWebHistory(),
    routes
});

const app = createApp({});

app.use(router);
app.use(createPinia());
app.mount('#app');

