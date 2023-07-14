import { createRouter, createWebHistory } from "vue-router";
import ProductIndex from "../components/products/index.vue";
import CreateProduct from "../components/products/CreateProduct.vue";
import EditProduct from "../components/products/EditProduct.vue";

import NotFound from "../components/NotFound.vue";

const routes = [
    {
        path: "/",
        component: ProductIndex,
        name: "index",
    },
    { path: "/products/create", component: CreateProduct },
    { path: "/products/edit/:id", component: EditProduct, name: "edit" },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
