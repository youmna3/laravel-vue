import { createRouter, createWebHistory } from "vue-router";
import ProductIndex from "../components/products/index.vue";
import CreateProduct from "../components/products/create.vue";
import NotFound from "../components/NotFound.vue";

const routes = [
    {
        path: "/",
        component: ProductIndex,
    },
    {
        path: "/product/create",
        component: CreateProduct,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
