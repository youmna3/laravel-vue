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
        <li class="list-group-item">
            <h5 class="mb-1">Name:{{ product.name }}</h5>
            <p class="mb-1">Description:{{ product.description }}</p>
            <p class="mb-1">Price: ${{ product.price }}</p>
            <p class="mb-1">Status: {{ product.status }}</p>
            <div v-for="image in product.images" :key="image.id">
                <img
                    :src="getImageUrl(image.image_url)"
                    alt="Product Image"
                    width="200"
                    class="img-thumbnail"
                />
            </div>
        </li>
    </ul>
</template>
