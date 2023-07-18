<script setup>
import { onMounted, ref } from "vue";
import { useRoute } from "vue-router";

let product = ref([]);
const route = useRoute();

onMounted(async () => {
    getProduct();
});
const getImageUrl = (filename) => {
    return `/api/${filename}`;
};
const getProduct = async () => {
    try {
        const id = route.params.id;

        const res = await axios.get(`/api/products/${id}`);
        console.log("res", res);
        product.value = res.data.product;
        console.log(product.value);
    } catch (err) {
        console.log(err.response.data);
    }
};
</script>

<template>
    <h4>Product info:</h4>
    <ul class="list-group">
        <li class="list-group-item">Name:{{ product.name }}</li>
        <li class="list-group-item">Description:{{ product.description }}</li>
        <li class="list-group-item">Price: ${{ product.price }}</li>
        <li class="list-group-item">Status: {{ product.status }}</li>
        <div v-for="image in product.images" :key="image.id">
            <img
                :src="getImageUrl(image.image_url)"
                alt="Product Image"
                width="200"
                class="img-thumbnail"
            />
        </div>

        <li class="list-group-item">
            <router-link
                :to="{ name: 'edit', params: { id: product.id } }"
                class="btn btn-success"
                >EDIT</router-link
            >
        </li>
        <!-- </li> -->
    </ul>
</template>
