import { createRouter, createWebHistory } from "vue-router";
import ProductIndex from "../components/products/index.vue";
import CreateProduct from "../components/products/CreateProduct.vue";
import EditProduct from "../components/products/EditProduct.vue";
import ShowProduct from "../components/products/ShowProduct.vue";

import PostIndex from "../components/posts/PostIndex.vue";
import CreatePost from "../components/posts/CreatePost.vue";
import NotFound from "../components/NotFound.vue";

const routes = [
    // Products Routs
    {
        path: "/",
        component: ProductIndex,
        name: "index",
    },
    { path: "/products/create", component: CreateProduct },
    { path: "/products/edit/:id", component: EditProduct, name: "edit" },
    {
        path: "/products/show/:id",
        component: ShowProduct,
        name: "products.show",
    },
    // Posts Routs
    {
        path: "/posts",
        component: PostIndex,
        name: "post.index",
    },
    {
        path: "/posts/create",
        component: CreatePost,
        name: "post.create",
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
