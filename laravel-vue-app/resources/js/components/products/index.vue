<script setup>
import { onMounted, ref } from "vue";

let products = ref([]);
onMounted(async () => {
    getProducts();
});
const getProducts = async () => {
    const res = await axios.get("api/products");
    console.log("res", res);
    products.value = res.data.products;
};
</script>
<template>
    <h4>List Of Products:</h4>
    <router-link class="btn btn-success" to="/products/create"
        >Add New Product</router-link
    >
    <hr />
    <table class="table table-striped-columns text-center">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Status</th>
                <th>Image</th>
                <th colspan="3">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="product in products" :key="product.id">
                <td>{{ product.id }}</td>
                <td>{{ product.name }}</td>
                <td>{{ product.description }}</td>
                <td>{{ product.price }}</td>
                <td>{{ product.status }}</td>
                <td></td>
                <td><a class="btn btn-success">EDIT</a></td>
                <td><a class="btn btn-danger">Delete</a></td>
            </tr>
        </tbody>
    </table>
</template>
