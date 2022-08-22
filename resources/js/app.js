import {
    createApp
} from "vue";

// Vue Toast
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

// Vue Router
import {
    createRouter,
    createWebHistory
} from "vue-router";
import {
    routes
} from "./routes";

// Vuex
import store from "./store";

// Axios
import axios from "axios";
axios.defaults.baseURL = "/api";
axios.interceptors.request.use(function (config) {
    const user = store.getters.user;
    if (user) {
        config.headers.Authorization = `Bearer ${user.access_token}`;
    }
    return config;
});
axios.interceptors.response.use(null, (error) => {
    if (error.response.status == 401) {
        store.commit("LOGOUT");
        router.push({
            name: "login"
        });
    }
    return Promise.reject(error.response);
});
window.axios = axios;

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const requiresAuth = to.matched.some((record) => record.meta.requiresAuth);
    const employeeAuth = to.matched.some((record) => record.meta.employeeAuth);
    const hrAuth = to.matched.some((record) => record.meta.hrAuth);
    const user = store.getters.user;

    if (requiresAuth && !user) {
        next({
            name: "login"
        });
    } else if (to.name == "login" && user) {
        next({
            name: "employeeForm"
        });
    } else if (employeeAuth && user.user && user.user.role == 1) {
        next({
            name: "employeeList"
        });
    } else if (hrAuth && user.user && user.user.role == 0) {
        next({
            name: "employeeForm"
        });
    } else {
        next();

    }
});

import HomeApp from "./HomeApp.vue";

const app = createApp({});

app.component("HomeApp", HomeApp);
app.use(router);
app.use(store);

app.use(VueToast);

app.mount("#app");
