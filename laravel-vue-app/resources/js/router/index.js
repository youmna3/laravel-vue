import { createRouter, createWebHistory } from "vue-router";
import ProductIndex from "../components/products/index.vue";
import CreateProduct from "../components/products/CreateProduct.vue";
import NotFound from "../components/NotFound.vue";

const routes = [
    {
        path: "/",
        component: ProductIndex,
    },
    { path: "/products/create", component: CreateProduct },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
